# init For ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import time
import re
import os
import shutil
import multiprocessing
import math
from concurrent.futures import ThreadPoolExecutor, wait

# 设置单个文件的最大值:209715200 200M
MAX_SINGLE_FILE_SIZE = 209715200
mutex = multiprocessing.Lock()
executor = ThreadPoolExecutor(max_workers=3)

# 遍历文件夹
def walk_file(file):
    file_list = list()
    for root, dirs, files in os.walk(file):
        # 遍历文件
        for f in files:
            file_list.append(f)

        # 空文件夹处理
        for d in dirs:
            if len(os.listdir(os.path.join(root, d))) == 0:
                file_list.append(d)
    return file_list

# 计算文件数量
def get_file_count(dir):
    return len(walk_file(dir))

def copy(src, target, queue):
    target_number = 1
    buffer = 1024
    # 文件夹
    if os.path.isdir(src):
        target_number = get_file_count(src)
        for root, dirs, files in os.walk(src):
            # 遍历文件
            for f in files:
                drive = os.path.splitdrive(target)[0]
                target = drive + os.path.splitdrive(os.path.join(root, f))[1]
                copy_single_file(buffer, os.path.join(root, f), target)
            # 空文件夹
            for d in dirs:
                drive = os.path.splitdrive(target)[0]
                target = drive + os.path.splitdrive(os.path.join(root, d))[1]
                # 检查文件的层级目录
                if not os.path.exists(target):
                    os.makedirs(target)
    else:
        copy_single_file(buffer, src, target)
    # 将拷贝完成的文件数量放入队列中
    queue.put(target_number)

# 拷贝单文件
def copy_single_file(buffer, src, target):
    file_size = os.path.getsize(src)
    rs = open(src, "rb")

    # 检查文件的层级目录
    parent_path = os.path.split(target)[0]
    if not os.path.exists(parent_path):
        os.makedirs(parent_path)

    ws = open(target, "wb")
    # 小文件直接读写
    if file_size <= MAX_SINGLE_FILE_SIZE:
        while True:
            content = rs.read(buffer)
            ws.write(content)
            if len(content) == 0:
                break
        ws.flush()
    else:
        # 设置每个线程拷贝的字节数 50M
        PER_THREAD_SIZE = 52428800
        # 构造参数并执行
        task_list = list()
        for i in range(math.ceil(file_size / PER_THREAD_SIZE)):
            byte_size = PER_THREAD_SIZE
            # 最后一个线程拷贝的字节数应该是取模
            if i == math.ceil(file_size / PER_THREAD_SIZE) - 1:
                byte_size = file_size % PER_THREAD_SIZE
            start = i * PER_THREAD_SIZE + i
            t = executor.submit(copy_file_thread, start, byte_size, rs, ws)
            task_list.append(t)
        wait(task_list)
    if rs:
        rs.close()
    if ws:
        ws.close()

# 多线程拷贝
def copy_file_thread(start, byte_size, rs, ws):
    mutex.acquire()
    buffer = 1024
    count = 0
    rs.seek(start)
    ws.seek(start)
    while True:
        if count + buffer <= byte_size:
            content = rs.read(buffer)
            count += len(content)
            write(content, ws)
        else:
            content = rs.read(byte_size % buffer)
            count += len(content)
            write(content, ws)
            break
    # global total_count
    # total_count += byte_size
    # print("\r拷贝进度为%.2f %%" % (total_count * 100 / file_size), end="")
    mutex.release()

def write(content, ws):
    ws.write(content)
    ws.flush()

def copy_dir(src, desc):
    # 获得待拷贝的文件总数(含空文件夹)
    total_number = get_file_count(src)
    # 分隔符检测
    src = check_separator(src)
    desc = check_separator(desc)
    # print("src:",src)
    # print("desc:",desc)

    file_dir_list = [src + "/" + i for i in os.listdir(src)]
    if os.path.exists(desc):
        shutil.rmtree(desc)

    # 进程池
    pool = multiprocessing.Pool(3)

    # 创建队列
    queue = multiprocessing.Manager().Queue()

    # 一个文件/目录开启一个进程去拷贝
    for f_name in file_dir_list:
        target = os.path.splitdrive(desc)[0] + "/" + os.path.splitdrive(f_name)[1]
        # target = desc + "/" + f_name[index_list("/", f_name)[1] + 1:]
        # print(target)
        # 创建target目录
        parent_path = os.path.split(target)[0]
        if not os.path.exists(parent_path):
            os.makedirs(parent_path)
        pool.apply_async(copy, args=(f_name, target, queue))

    start = time.time()
    pool.close()
    # pool.join()
    count = 0
    while True:
        count += queue.get()
        # 格式化输出时两个%输出一个%,不换行,每次定位到行首,实现覆盖
        print("\r当前进度为 %.2f %%" % (count * 100 / total_number), end="")
        if count >= total_number:
            break

    executor.shutdown()
    end = time.time()
    print()
    print("耗时-----", (end - start), "s")

# 查找指定字符出现的全部索引位置
def index_list(c, s):
    return [i.start() for i in re.finditer(c, s)]

# 检测目录结尾是否有 "/"
def check_separator(path):
    if path.rindex("/") == len(path) - 1:
        return path[0:path.rindex("/")]
    return path

def main(path,servername):
    try:
        os.makedirs('{}/{}/sefolder'.format(path,servername))
        os.system('mklink /d "{path}/{servername}/sefolder/Content" "{path}/{servername}/ShooterGame/Content" && exit'.format(path=path,servername=servername))
        os.system('mklink /d "{path}/{servername}/sefolder/Saved" "{path}/{servername}/ShooterGame/Saved" && exit'.format(path=path,servername=servername))
        copy_dir('{}/ExampleServer'.format(path), '{}/{}'.format(path,servername))
        #os.system('robocopy {path}\ExampleServer {path}\{servername} /e && exit'.format(path=path,servername=servername))
    except:
        print('[E {}] [HTTP] Init Server {} error'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] Init Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))