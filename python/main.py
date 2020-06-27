# Main For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import yaml,os,sys,threading,socket
from threading import Thread
from queue import Queue

# 检测文件完整性
if os.path.exists(os.path.abspath(os.path.dirname(__file__)) + '/http.py') == False or os.path.exists(os.path.abspath(os.path.dirname(__file__)) + '/ftp.py') == False:
    print('[EROOR] File is missing, please try to download the program again')
    input('Press enter to end...')
    sys.exit()
else:
    import http
    import ftp

class main(object):
    def __init__(self, ftp_host, ftp_port, http_host, http_port, token, path, q):
        self.run_ftp(ftp_host, ftp_port)
        self.run_http(http_host, http_port, token, path, q)
        self.run_q(q)

    def run_http(self, host, port, token, path, channel_port):
        self.th_http = Thread(target=http.main, args=(host, port, token, path, channel_port))
        self.th_http.start()

    def run_ftp(self, host, port):
        self.th_ftp = ftp.ftp_server(host, port)
        self.th_ftp.start()
        global public_data
        data = public_data[0]['user'] 
        user_data = [key for key,value in data.items()]
        for i in range(len(user_data)):
            self.ftp_add_user(data[user_data[i]]['username'], data[user_data[i]]['password'], data[user_data[i]]['path'])

    def run_q(self, in_q):
        while True:
            get_data = q.get()
            parameter = get_data.split('&')
            data = {}
            for a in range(len(parameter)):
                single = parameter[a].split('=', 1)
                if len(single) == 2:
                    data[single[0]] = single[1]
            global public_data
            if data['type'] == 'add':
                try:
                    self.ftp_add_user(data['username'],data['password'],data['path'])
                except:
                    print('[ERROE] Create ftp user for {} error, cannot find folder or the user already exists'.format(data['servername']))
                else:
                    user_data = {'username':data['username'],'password':data['password'],'path':data['path']}
                    public_data[0]['user'][data['servername']] = user_data
                    config().update_config()
                    print('[INFO] Create ftp user for {}'.format(data['servername']))
            elif data['type'] == 'del':
                try:
                    self.ftp_del_user(data['username'])
                    del public_data[0]['user'][data['servername']]
                except:
                    print('[ERROE] Delete ftp user for {} error, the username or server name cannot be found'.format(data['servername']))
                else:
                    config().update_config()
                    print('[INFO] Delete ftp user for {}'.format(data['servername']))

    def ftp_add_user(self, user, passwd, loc):
        self.th_ftp.add_user(user, passwd, loc)

    def ftp_del_user(self, user):
        self.th_ftp.del_user(user)

class config(object):
    def __init__(self):
        self.config = os.path.abspath(os.path.dirname(__file__)) + '\\'+ 'config.yml'

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
    
    def update_config(self):
        with open(self.config, 'w') as f:
            with open(self.config, 'w') as f:
                global public_data
                data = yaml.dump(public_data, f)

public_data = {}
q = Queue()

if __name__ == "__main__":
    print('[INFO] Checking file integrity...')
    
    config_path = os.path.abspath(os.path.dirname(__file__)) + '\\'+ 'config.yml'
    # 若配置文件不存在，则创建空白配置文件
    if (os.path.exists(config_path)) == False:
        config().create_config()
    config().read_config()

    global_data = public_data[0]['global']
    main(global_data['ftp_host'], global_data['ftp_port'], global_data['http_host'], global_data['http_port'], global_data['token'], global_data['path'],q)

