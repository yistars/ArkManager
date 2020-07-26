# init For ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import os,time

def main(path,servername):
    try:
        os.system('robocopy "{path}/ExampleServer" "{path}/{servername}" /e && exit'.format(path=path,servername=servername))
    except:
        print('[E {}] [HTTP] Init Server {} error, cannot copy file'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))
    else:
        print('[I {}] [HTTP] Init Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))