# http for ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import os,socket,base64,shutil,threading
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
        print('[INFO] Serving HTTP on port %s ...' % PORT)

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
                # 确认 token 与 验证 token
                if ('token' in data) == False or ('servername' in data) == False:
                    break
                elif data['token'] != token:
                    break
                # 根据 action 确定执行函数
                if data['action'] == 'start':
                    if ('args' in data):
                        right = server_start(data['args'], data['servername'], path)
                elif data['action'] == 'kill':
                    right = server_kill(data['servername'], path)
                elif data['action'] == 'init':
                    right = server_init(data['servername'], path)
                elif data['action'] == 'delete':
                    right = server_kill(data['servername'], path)
                    right = server_delete(data['servername'], path)
                elif data['action'] == 'ftp':
                    if ('type' in data) and ('username' in data) and ('password' in data):
                        if data['type'] == 'add':
                            right = True
                        elif data['type'] == 'del':
                            right = True
                        elif data['type'] == 'edit':
                            right = True
        # 返回码
        if right:
            response_line = 'HTTP/1.1 200 OK\r\n'
            client_socket.send(response_line.encode('utf-8'))
        else:
            response_line = 'HTTP/1.1 403 Forbidden\r\n'
            client_socket.send(response_line.encode('utf-8'))
        # 断开与客户端连接
        client_socket.close()

    def server_start(self, args, servername, path):
        try:
            args = base64.b64decode(args.decode("utf-8"))
        except:
            print('[ERROR] Start Server {} error, wrong arg'.format(servername))
            return True
        else:
            os.system('start "{1}" /normal {0}/{1}/ShooterGame/Binaries/Win64/ShooterGameServer.exe {2}'.format(path,servername,args))
            print('[INFO] Start Server {}'.format(servername))
            return False

    def server_kill(self, servername, path):
        os.system('taskkill /fi "windowtitle eq {}"'.format(path,servername))
        os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *'.format(path,servername))
        os.system('taskkill /fi "windowtitle eq {}"'.format(path,servername))
        os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *'.format(path,servername))
        print('[INFO] Kill Server {}'.format(servername))

    def server_init(self, servername, path):
        shutil.copytree('{}/ExampleServer'.format(path,servername),'{}/{}'.format(path,servername))
        print('[INFO] Init Server {}'.format(servername))

    def server_delete(self, servername, path):
        shutil.rmtree('{}/{}/ShooterGame/Content'.format(path,servername))
        os.makedirs('{}/{}/ShooterGame/Content'.format(path,servername))
        print('[INFO] Delete Server {}'.format(servername))

    def __del__(self):
        # 当服务端程序结束时停止服务器服务
        self.server_socket.close()
    
def main(HOST, PORT, token, path):
    http(HOST, PORT).run(token, path)

main('127.0.0.1',4444,'123456','D://')