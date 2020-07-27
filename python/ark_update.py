# update For ArkManager
# By Bing_Yanchi
# DO NOT CHANGE
import os,time

def main(path,servername):
    os.system('steamcmd +login anonymous +force_install_dir {path}/{servername} +app_update 376030 +quit'.format(path=path,servername=servername))
    print('[I {}] [HTTP] Update Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),servername))