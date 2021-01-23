# kill For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import os,time
def main(data,path):
	os.system('taskkill /fi "windowtitle eq {}"'.format(path,data['servername']))
	os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *"'.format(path,data['servername']))
	os.system('taskkill /fi "windowtitle eq {}"'.format(path,data['servername']))
	os.system('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *"'.format(path,data['servername']))
	#print('taskkill /fi "windowtitle eq {}/{}/ShooterGame/Binaries/Win64/ShooterGameServer.exe *"'.format(path,data['servername']))
	#print('taskkill /fi "windowtitle eq {}"'.format(path,data['servername']))
	print('[I {}] [HTTP] Kill Server {}'.format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()),data['servername']))