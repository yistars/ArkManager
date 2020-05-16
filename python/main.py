# main
# By Bing_Yanchi
#from module import http_monitoring
import yaml,os,threading,sys,_thread
import http
import _thread

class main(object):
    config = 'config.yml'
    def __init__(self, config, module):
        print('[INFO] Checking file integrity...')
        # 检查文件完整性
        #if os.path.exists(module) == False or os.path.exists(module + '/http.py') == False:
        #    print('[EROOR] File is missing, please try to download the program again')
        #    input('Press enter to end...')
        #    sys.exit()
        # 若配置文件不存在，则创建空白配置文件
        if os.path.exists(config) == False:
            self.create_config()
        self.read_config(config)
        self.run_http(module)

    def create_config(self):
        with open(config, 'w') as f:
            raw_data = [{'http':{'host':'0.0.0.0','port':'4444','token':'123456','path':"D:/dir/dir"},'ftp':{}}]
            with open(config, 'w') as f:
                data = yaml.dump(raw_data, f)

    def read_config(self, config):
        print()
        #with open(config) as f:
        #    data = yaml.load(f)
            #print(data)

    def run_http(self, module):
        #threading.start_new_thread(http.run, ('123456','D:/'))
        #threading.Thread(target=http, args=('127.0.0.1','4444'), daemon=True).start()
        #threading.Thread(target=http.run, args=('123456','D:/'), daemon=True).start()
        #Process(target=http,arg=('127.0.0.1','4444')).start()
        #Process(target=http,arg=('123456','D:/')).start()
        #os.system('python ' + os.getcwd() + '\\python\\' + module + '\\' + 'http.py')
        run = http.http()
        _thread.start_new_thread(run('127.0.0.1','4444').main, ('123456','D:/'))

if __name__ == "__main__":
    main('config.yml', 'module')
