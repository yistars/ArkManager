# http for ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import os,socket,base64,shutil,yaml,threading
# 创建服务器类
class http(object):
    def __init__(self, HOST, PORT):
        # 创建Socket对象
        self.server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # 设置端口复用
        self.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, True)
        # 绑定IP端口
        self.listen_socket.bind((HOST, PORT))
        # 设置监听
        self.listen_socket.listen(128)
        # 信息输出
        print('[INFO] Serving HTTP on port %s ...' % PORT)

    def run(self):
        while True:
            # 等待客户端连接
            client_socket, ip_port = self.server_socket.accept()
            threading.Thread(target=self.task, args=(client_socket, ip_port), daemon=True).start()

    def task(self, client_socket, ip_port):
        print()
