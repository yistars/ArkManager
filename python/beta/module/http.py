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
        # 接收数据
        recv_data = client_socket.recv(1024).decode('utf-8')
        # 拆分换行符便于检索
        info = recv_data.decode("utf-8").split('\n')
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
			    if ('token' in data) == False:
			    	break
			    elif data['token'] != token:
			    	break
			    # 根据 action 确定执行函数
			    if data['action'] == 'start':
			    	if ('servername' in data) and ('args' in data):
			    		right = True
			    		start(data)
			    elif data['action'] == 'kill':
			    	if ('servername' in data):
			    		right = True
			    		kill(data)
			    elif data['action'] == 'init':
			    	if ('servername' in data):
			    		right = True
			    		init(data)
			    elif data['action'] == 'delete':
			    	if ('servername' in data):
			    		right = True
			    		kill(data)
			    		delete(data)
			    elif data['action'] == 'ftp':
				    if ('servername' in data) and ('type' in data) and ('username' in data) and ('password' in data):
				    	if data['type'] == 'add':
				    		right = True
				    	elif data['type'] == 'del':
				    		right = True
				    	elif data['type'] == 'edit':
				    		right = True
        if right:
            response_line = 'HTTP/1.1 200 OK\r\n'
            client_socket.send(response_line.encode('utf-8'))
        else:
            response_line = 'HTTP/1.1 403 Forbidden\r\n'
            client_socket.send(response_line.encode('utf-8'))
        # 断开与客户端连接
        client_socket.close()