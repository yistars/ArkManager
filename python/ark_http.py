# http For ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
from queue import Queue
from threading import Thread
import os,socket,base64,shutil,threading,time
import ark_kill,ark_init,ark_config
# 创建服务器类
class http(object):
    def __init__(self, HOST, PORT):
        # 创建Socket对象
        self.server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # 设置端口复用
        self.server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, True)
        # 绑定IP端口
        self.server_socket.bind((HOST, PORT))
        # 设置监听
        self.server_socket.listen(128)
        # 信息输出
        print('[I {}] [HTTP] Serving HTTP on port {} ...'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()), PORT))

    def run(self, token, path, out_q, c):
        while True:
            # 等待客户端连接
            client_socket, ip_port = self.server_socket.accept()
            threading.Thread(target=self.task, args=(client_socket, ip_port, token, out_q, c), daemon=True).start()
            self.path = path

    def task(self, client_socket, ip_port, token, out_q, in_c):
        # 接收数据
        recv_data = client_socket.recv(1024).decode('utf-8')
        # 拆分换行符便于检索
        info = recv_data.split('\n')
        # 设定是否返回200
        right = False
        data = ''
        for i in range(len(info)):
            if info[i].find('POST') == 0:
                # 拆分 POST 和 地址
                post = info[i].split(' ')
                parameter = post[1].lstrip('/?').split('&')
                data = {}
                for a in range(len(parameter)):
                    single = parameter[a].split('=', 1)
                    if len(single) == 2:
                        data[single[0]] = single[1]
                # 确认 token 与 验证 token
                if ('token' in data) == False or ('servername' in data) == False:
                    break
                elif data['token'] != token:
                    break
                # 根据 action 确定执行函数
                if data['action'] == 'start':
                    if ('args' in data):
                        right = self.server_start(data['args'], data['servername'])
                elif data['action'] == 'kill':
                    right = self.server_kill(data)
                elif data['action'] == 'init':
                    right = self.server_init_link(data['servername'])
                    if right and (('password' in data) and ('username' in data)):
                        right = self.ftp_add(data['username'],data['password'],data['servername'],out_q)
                    else:
                        continue
                    right = self.server_init_copy(data['servername'])
                elif data['action'] == 'delete':
                    right = self.server_kill(data['servername'])
                    right = self.server_delete(data['servername'])
                elif data['action'] == 'update':
                    if 'servername' in data:
                        right = self.server_update(data['servername'])
                elif data['action'] == 'ftp':
                    if ('type' in data) and ('username' in data):
                        if data['type'] == 'add':
                            right = self.ftp_add(data['username'],data['password'],data['servername'],out_q)
                        elif data['type'] == 'del':
                            right = self.ftp_del(data['username'],data['servername'],out_q)
                        elif data['type'] == 'edit':
                            right = self.ftp_add(data['username'],data['password'],data['servername'],out_q)
                            right = self.ftp_del(data['username'],data['servername'],out_q)
                elif data['action'] == 'GUS':
                    if ('type' in data) and ('filename' in data):
                        if data['type'] == 'pull':
                            data = self.GUS_get(data['servername'],filename,in_c)
                        elif data['type'] == 'push':
                            right = self.GUS_post(data['servername'],filename)
        # 返回状态码
        if data != '':
            http_response = "HTTP/1.1 200 OK" + '\r\n\r\n' + data
        elif right:
            http_response = "HTTP/1.1 200 OK" + '\r\n'
        else:
            http_response = "HTTP/1.1 403 Forbidden" + '\r\n'
        
        client_socket.send(http_response.encode('utf-8'))
        # 断开与客户端连接
        client_socket.close()

    # 服务器控制
    def server_start(self, args, servername):
        try:
            args = base64.b64decode(args).decode(encoding='utf-8')
        except:
            print('[E {}] [HTTP] Start Server {} error, wrong arg'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
            return False
        else:
            os.system('start "{1}" /normal {0}/{1}/ShooterGame/Binaries/Win64/ShooterGameServer.exe {2}'.format(self.path,servername,args))
            print('[I {}] [HTTP] Start Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
            return True

    def server_kill(self, data):
        self.th_kill = Thread(target=ark_kill.main, args=(data, self.path))
        self.th_kill.start()
        return True

    def server_init_link(self, servername):
        try:
            os.makedirs('{}/{}/sefolder'.format(self.path,servername))
            os.system('mklink /d "{path}/{servername}/sefolder/Content" "{path}/{servername}/ShooterGame/Content" && exit'.format(path=self.path,servername=servername))
            os.system('mklink /d "{path}/{servername}/sefolder/Saved" "{path}/{servername}/ShooterGame/Saved" && exit'.format(path=self.path,servername=servername))
            os.system('mklink "{path}/{servername}/sefolder/config.json" "{path}/{servername}/ShooterGame/Binaries/Win64/config.json" && exit'.format(path=self.path,servername=servername))
            os.system('mklink /d "{path}/{servername}/sefolder/ArkApi" "{path}/{servername}/ShooterGame/Binaries/Win64/ArkApi" && exit'.format(path=self.path,servername=servername))
            f = open('{path}/{servername}/sefolder/Readme.txt'.format(path=self.path,servername=servername),'w', encoding='utf-8')
            f.writelines('ArkApi 为插件存放目录，config.json 为 ArkApi 相关的配置文件')
            f.close()
        except:
            print('[E {}] [HTTP] Init Server {} error, create link error'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
            return False
        else:
            return True

    def server_init_copy(self, servername):
        self.th_init = Thread(target=ark_init.main, args=(self.path,servername))
        self.th_init.start()
        return True

    def server_delete(self, servername):
        shutil.rmtree('{}/{}'.format(self.path,servername))
        print('[I {}] [HTTP] Delete Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
        return True

    def server_update(self, servername):
        self.th_update = Thread(target=ark_update.main, args=(self.path, servername))
        self.th_update.start()
        return True

    def ftp_add(self, username, password, servername, out_q):
        data = 'type=add&username={}&password={}&servername={}&path={}/{}'.format(username,password,servername,self.path,servername)
        send = public_channel_client(out_q)
        send.run(data)
        return True
    
    def ftp_del(self, username, servername, out_q):
        data = 'type=del&username={}&servername={}'.format(username,servername)
        send = public_channel_client(out_q)
        send.run(data)
        return True
    
    def GUS_get(self, servername, filename, in_c):
        self.th_gus_get = Thread(target=ark_config.main_get, args=(self.path, servername, filename, in_c))
        self.th_gus_get.start()
        data = c.get()
        if data == 'error':
            return """/
            403 Forbidden""".replace('    ','')
        else:
            data = base64.b64encode(data.encode("utf-16")).decode('utf-16')
            return data

    def GUS_post(self, servername, filename, data):
        try:
            data = base64.b64decode(data)
        except:
            print('[I {}] [HTTP] post {} config file error, maybe data is error'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
        else:
            self.th_gus_post = Thread(target=ark_config.post, args=(self.path, servername, data, filename))
            self.th_gus_post.start()
            return True

    def __del__(self):
        # 当服务端程序结束时停止服务器服务
        self.server_socket.close()

c = Queue()
'''
公共信道与主程序沟通
FTP 由主程序控制
请求不由主程序控制
信道用于传递请求
'''
class public_channel_client(object):
    def __init__(self, out_q):
        self.q = out_q

    def run(self, data):
        self.q.put(data)

def main(HOST, PORT, token, path, out_q):
    http(HOST, int(PORT)).run(token, path, out_q, c)
