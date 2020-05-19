
import threading
 
flag = 0
# 为线程定义一个函数
def print_time():
   def printOne():
      while 1:
         print(111111111111)
         print(222222222222)
         print(333333333333)
         print(444444444444)
         print(555555555555)
         print(666666666666)
   th1 = threading.Thread(target=printOne)
   th1.setDaemon(True)
   th1.start()
   while 1:
      if flag:
         print("正在停止这个程序！！！")
         break
i=5
if i == 5:
      th = threading.Thread(target=print_time)
      th.start()
      flag=1
      th.join()
      print("++++++++++++++++++++++++++++++++++++++++++++++++++")
while 1:
   pass