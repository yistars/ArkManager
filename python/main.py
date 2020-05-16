# main
# By Bing_Yanchi
#from module import http_monitoring
import yaml,os,threading,sys,_thread
import http

class main(object):
    config = 'config.yml'
    def __init__(self, config, module):
        print('[INFO] Checking file integrity...')
        # 检查文件完整性
        #if os.path.exists('http.py') == False:
        #    print('[EROOR] File is missing, please try to download the program again')
        #    input('Press enter to end...')
        #    sys.exit()
        # 若配置文件不存在，则创建空白配置文件
        if os.path.exists(config) == False:
            self.create_config(config)
        self.read_config(config)
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
            print('1')

    def run_http(self, module):
        #threading.start_new_thread(http.run, ('123456','D:/'))
        #threading.Thread(target=http, args=('127.0.0.1','4444'), daemon=True).start()
        _thread.start_new_thread(http.main, ('127.0.0.1',4444,'123456','D:/'))
        print("hiiii")

    def run_ftp(self, module):
        _thread.start_new_thread(http('127.0.0.1','4444').main, ('123456','D:/'))

if __name__ == "__main__":
    main('config.yml', 'module')
    while True:
        pass
