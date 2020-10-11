# config For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import time,json
from configparser import ConfigParser
from queue import Queue

def init(path,servername):
    config_file = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    try:
        f_r = open(config_file,'r')
        last_key,config_data = '',''
        for line in f_r:
            line = line.strip('\n')
            last_line = line
            if ('=' in line) and (line.split('=')[0] != last_key):
                config_data += line + '\n'
                last_key = line.split('=')[0]
            else:
                config_data += line + '\n'
        f_w = open(config_file,'w',encoding='utf-16')
        f_w.write(config_data)
    except:
        print('[E {}] [HTTP] init {} config file error, maybe file is break'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] Init {} config file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))

def read(path,servername,out_c):
    ini_path = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    data = {}
    cfg = ConfigParser()
    cfg.read(ini_path,encoding='utf-16')
    for s in cfg.sections():
        print(s)
        data[s] = dict(cfg.items(s))
    print('[I {}] [HTTP] read {} config file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    send = config_channel_client(out_c)
    send.run(json.dumps(data))

def edit(path,servername,data):
    ini_path = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    data = json.loads(read(path,servername))
    

'''
配置读取信道
用于与 http 部分沟通
'''
class config_channel_client(object):
    def __init__(self, out_c):
        self.c = out_c

    def run(self, data):
        self.c.put(data)

