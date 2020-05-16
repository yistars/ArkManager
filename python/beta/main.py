# main
# By Bing_Yanchi
#from module import http_monitoring
import yaml,os

class main(object):
    config = 'config.yml'
    def __init__(self, config, module):
        print('[INFO] Checking file integrity...')
        if (os.path.exists(module) == False) or (os.path.exists(module + '/http.py')):
            print('[EROOR] File is missing, please try to download the program again')
            input('Press enter to end...')
        if os.path.exists(config) == False:
            create_config()
        read_config()


    def create_config(self):
        with open(config, 'w') as f:
            raw_data = [{'http':{'host':'0.0.0.0','port':'4444','token':'123456','path':"D:/dir/dir"},'ftp':{}}]
            with open(config, 'w') as f:
                data = yaml.dump(raw_data, f)

    def read_config(self):
        with open(config) as f:
            data = yaml.load(f)
            print(data)
    
    def run_http(self):


if __name__ == "__main__":
    main('config.yml', 'module')