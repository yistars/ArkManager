# Main For Arkmanager
# By Bing_Yanchi
import yaml,os,threading,sys
import time
import threading
import http
import ftp
import socket

class main(object):
    config = 'config.yml'
    def __init__(self, module):
        self.run_ftp()
        self.run_http(module)
        
    def create_config(self, config):
        with open(config, 'w') as f:
            raw_data = [{'http':{'host':'0.0.0.0','port':'4444','token':'123456','path':"D:/dir/dir"},'ftp':{}}]
            with open(config, 'w') as f:
                data = yaml.dump(raw_data, f)

    def read_config(self, config):
        with open(config) as f:
            data = yaml.load(f)
            print(data)

    def run_http(self, module):
        th_http = http.main('127.0.0.1',4444,'123456','D:/')
        th_http.start()

    def run_ftp(self):
        th_ftp = ftp.ftp_server()
        th_ftp.start()
        th_ftp.add_user('user','password',".",'elradfmwM')

    def main_socket(self):
        s = socket.socket()
        s.bind(('', 0))
        print(s.getsockname()[1])

class public_channel_server(object):
    def __init__(self):
        # 创建Socket对象
        self.server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # 设置端口复用
        self.server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, True)
        # 绑定IP端口
        self.server_socket.bind(('127.0.0.1', 0))
        # 设置监听
        self.server_socket.listen(128)
        # 获取端口
        global public_channel_port
        public_channel_port = self.server_socket.getsockname()[1]
        # 信息输出
        print('[INFO] Serving public_channel_server on port %s ...' % public_channel_port)
        

    def run(self, token, path):
        while True:
            # 等待客户端连接
            client_socket, ip_port = self.server_socket.accept()
            threading.Thread(target=self.task, args=(client_socket, ip_port, token, path), daemon=True).start()
    
    def task(self, client_socket, ip_port, token, path):
        # 接收数据
        recv_data = client_socket.recv(1024).decode('utf-8')
        # 拆分换行符便于检索
        info = recv_data.split('\n')
        # 设定是否返回200
        right = False
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

class config(object):
    def __init__(self, config, module):
        print('[INFO] Checking file integrity...')
        # 检查文件完整性
        #if not os.path.exists('http.py'):
        #    print('[EROOR] File is missing, please try to download the program again')
        #    input('Press enter to end...')
        #    sys.exit()
        # 若配置文件不存在，则创建空白配置文件
        #if os.path.exists(config) == False:
        #    self.create_config(config)
        #self.read_config(config)
        self.main_socket()
        self.run_ftp()
        self.run_http(module)

public_channel_port = 0
if __name__ == "__main__":
    public_channel_server()
    main('module')
    config('config.yml')
    
    while True:
        pass
