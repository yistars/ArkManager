# main
# By Bing_Yanchi
#from module import http_monitoring
import yaml
import os

config = 'config.yml'

def create_config():
    with open(config, 'w') as f:
        raw_data = [{'http':{'host':'0.0.0.0','port':'4444','token':'123456','path':"D:/dir/dir"},'ftp':{}}]
        with open(config, 'w') as f:
            data = yaml.dump(raw_data, f)

def read_config():
    with open(config) as f:
        data = yaml.load(f)
        print(data)

if __name__ == "__main__":
    if os.path.exists(config) == False:
        create_config()
    read_config()