# config For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import time,json
from configparser import ConfigParser
from queue import Queue

def init(path,servername):
    config_file = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    try:
        f_r = open(config_file,'r',encoding='utf-16')
        last_key,config_data = '',''
        for line in f_r:
            line = line.strip('\n')
            last_line = line
            if ('=' in line) and (line.split('=')[0] != last_key):
                config_data += line + '\n'
                last_key = line.split('=')[0]
            elif ('=' in line) and (line.split('=')[0] == last_key):
                continue
            else:
                config_data += line + '\n'
        f_w = open(config_file,'w',encoding='utf-16')
        f_w.write(config_data)
    except:
        print('[E {}] [HTTP] init {} config file error, maybe file is break'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] Init {} config file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))

def get(path,servername,out_c):
    ini_path = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    # 因 Json 传输方案弃用，此部分暂时丢弃
    '''
    data = {}
    cfg = ConfigParser()
    cfg.read(ini_path,encoding='utf-16')
    for s in cfg.sections():
        data[s] = dict(cfg.items(s))
    
    send.run(json.dumps(data))
    '''
    try:
        with open(ini_path, 'r', encoding='utf-16') as f:
            data = f.read()
        send = config_channel_client(out_c)
    except:
        print('[E {}] [HTTP] read {} config file error, maybe file is break'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
        send.run('error')
    else:
        print('[I {}] [HTTP] read {} config file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
        send.run(data)

def post(path,servername,data):
    ini_path = "{}/{}/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini".format(path,servername)
    # 因 Json 传输方案弃用，此部分暂时丢弃
    '''
    with open(ini_path, 'w') as f:
        dic = json.load(data)
        cfg = ConfigParser()
        for section, section_items in zip(dic.keys(), dic.values()):
            cfg._write_section(f, section, section_items.items(), delimiter='=')
    '''
    try:
        with open(ini_path, 'w', encoding='utf-16') as f:
            f.write(data)
    except:
        print('[I {}] [HTTP] update {} config file error, maybe file is break'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] update {} config file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))

'''
配置读取信道
用于与 http 部分沟通
'''
class config_channel_client(object):
    def __init__(self, out_c):
        self.c = out_c

    def run(self, data):
        self.c.put(data)

def main_get(path,servername,out_c):
    init(path,servername)
    get(path,servername,out_c)