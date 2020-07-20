# init For ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import threading
import os
import shutil
import time

# 创建拷贝任务
def copy_work(source_dir, dest_dir, file_name):
    # 拼接文件名路径
    source_file_path = source_dir + '/' + file_name
    dest_file_path = dest_dir + '/' + file_name
    # 打开目标文件
    with open(dest_file_path, 'wb') as dest_file:
        # 打开源文件
        with open(source_file_path, 'rb') as source_file:
            # 写入数据
            while True:
                source_file_data = source_file.read(1024)
                if source_file_data:
                    dest_file.write(source_file_data)
                else:
                    break

def copy_main(source_dir, dest_dir):
    if os.path.exists(source_dir):
        if not os.path.exists(dest_dir):
            # 创建目标文件夹
            os.mkdir(dest_dir)
        # 获取源目录文件列表
        source_file_list = os.listdir(source_dir)
        for file_name in source_file_list:
            copy_thread = threading.Thread(target=copy_work, args=(source_dir, dest_dir, file_name))
            copy_thread.start()
    else:
        print('[E {}] [HTTP] Init Server {} error'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))

def main(path,servername):
    try:
        os.makedirs('{}/{}/sefolder'.format(path,servername))
        os.system('mklink /d "{path}/{servername}/sefolder/Content" "{path}/{servername}/ShooterGame/Content" && exit'.format(path=path,servername=servername))
        os.system('mklink /d "{path}/{servername}/sefolder/Saved" "{path}/{servername}/ShooterGame/Saved" && exit'.format(path=path,servername=servername))
        copy_main('{}/ExampleServer'.format(path), '{}/{}'.format(path,servername))
    except:
        print('[E {}] [HTTP] Init Server {} error'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] Init Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))