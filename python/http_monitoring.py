# HTTP Monitoring
# By Bing_Yanchi
import os
import socket
import base64
import shutil
# 设置内容
HOST = ''
PORT = 4444
token = '123456'
path = ""

listen_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listen_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listen_socket.bind((HOST, PORT))
listen_socket.listen(1)
print('[INFO] Serving HTTP on port %s ...' % PORT)

def start(data):
	servername = data['servername']
	try:
		args = base64.b64decode(data['args']).decode("utf-8")
	except:
		print('[ERROR] Start Server {} error, wrong arg'.format(servername))
		global right
		right = False
	else:
		os.system('start "{1}" /normal {0}/{1}/ShooterGame/Binaries/Win64/ShooterGameServer.exe {2}'.format(path,servername,args))
		print('[INFO] Start Server {}'.format(servername))

def kill(data):
	servername = data['servername']
	os.system('taskkill /fi "windowtitle eq {}"'.format(path,servername))
	os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *'.format(path,servername))
	os.system('taskkill /fi "windowtitle eq {}"'.format(path,servername))
	os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *'.format(path,servername))
	print('[INFO] Kill Server {}'.format(servername))

def init(data):
	servername = data['servername']
	shutil.copytree('{}/ExampleServer'.format(path,servername),'{}/{}'.format(path,servername))
	print('[INFO] Init Server {}'.format(servername))

def delete(data):
	servername = data['servername']
	shutil.rmtree('{}/{}/ShooterGame/Content'.format(path,servername))
	os.makedirs('{}/{}/ShooterGame/Content'.format(path,servername))
	print('[INFO] Delete Server {}'.format(servername))

while True:
	client_connection, client_address = listen_socket.accept()
	request = client_connection.recv(1024)

	# 拆分换行符便于检索
	info = request.decode("utf-8").split('\n')
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
				break
			elif data['action'] == 'kill':
				if ('servername' in data):
					right = True
					kill(data)
				break
			elif data['action'] == 'init':
				if ('servername' in data):
					right = True
					init(data)
				break
			elif data['action'] == 'delete':
				if ('servername' in data):
					right = True
					kill(data)
					delete(data)
				break
			break
	# 返回状态码
	if right:
		http_response = """/
		HTTP/1.1 200 OK""".replace('\t','')
	else:
		http_response = """/
		HTTP/1.1 403 Forbidden""".replace('\t','')
	right = False

	client_connection.sendall(http_response.encode("utf-8"))
	client_connection.close()
