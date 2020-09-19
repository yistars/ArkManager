# config For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import time

def init(path,servername):
    config_file = '{}/{}'.format(path,servername)
    f_r = open(config_file,'r')
    last_key,config_data = '',''

    try:
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