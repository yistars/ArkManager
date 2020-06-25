# Main For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import yaml,os,sys,threading,socket

# 检测文件完整性
if os.path.exists(os.path.abspath(os.path.dirname(__file__)) + '/http.py') == False or os.path.exists(os.path.abspath(os.path.dirname(__file__)) + '/ftp.py') == False:
    print('[EROOR] File is missing, please try to download the program again')
    input('Press enter to end...')
    sys.exit()
else:
    import http
    import ftp

class main(object):
    config = 'config.yml'
    def __init__(self, ftp_host, ftp_port, http_host, http_port, token, path, channel_port):
        self.run_ftp(ftp_host, ftp_port)
        self.run_http(http_host, http_port, token, path, channel_port)

    def run_http(self, host, port, token, path, channel_port):
        self.th_http = http.main(host, port, token, path, channel_port)
        self.th_http.start()

    def run_ftp(self, host, port):
        self.th_ftp = ftp.ftp_server(host, port)
        self.th_ftp.start()

    def ftp_add_user(self):
        self.th_ftp.add_user('user','password',".",'elradfmwM')

class public_channel_server(object):
    def __init__(self):
        # 创建Socket对象
        self.server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # 设置端口复用
        self.server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, True)
        # 绑定IP端口
        self.server_socket.bind(('localhost', 0))
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
    def __init__(self, config):
        print('[INFO] Checking file integrity...')
        self.config = os.path.abspath(os.path.dirname(__file__)) + '\\'+ config
        # 若配置文件不存在，则创建空白配置文件
        if (os.path.exists(self.config)) == False:
            self.create_config()
        self.read_config()

    def create_config(self):
        with open(self.config, 'w') as f:
            raw_data = [{'global':{'ftp_host':'0.0.0.0','ftp_port':'21','http_host':'0.0.0.0','http_port':'4444','token':'123456','path':"D:/dir/dir"},'user':{}}]
            with open(self.config, 'w') as f:
                data = yaml.dump(raw_data, f)

    def read_config(self):
        with open(self.config) as f:
            data = yaml.load(f, Loader=yaml.FullLoader)
        global public_data
        public_data = data
    
    def write_data(self):
        global public_data
    
    def delete_data(self):
        global public_data

public_channel_port = 0
public_data = {}

if __name__ == "__main__":
    config('config.yml')
    public_channel_server()
    global_data = public_data[0]['global']
    main(global_data['ftp_host'], global_data['ftp_port'], global_data['http_host'], global_data['http_port'], global_data['token'], global_data['path'], public_channel_port)

    while True:
        pass
