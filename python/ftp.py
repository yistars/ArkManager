# ftp For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import threading
from pyftpdlib.authorizers import DummyAuthorizer
from pyftpdlib.handlers import FTPHandler
from pyftpdlib.servers import FTPServer

class ftp_server(threading.Thread):
   def __init__(self):
       super(ftp_server, self).__init__(name='ftp_server')
       self.authorizer = DummyAuthorizer()
       
   def run(self, host, port):
       self.handler = FTPHandler
       self.handler.authorizer = self.authorizer
       self.address = (host, int(port))
       self.server = FTPServer(self.address, self.handler)
       self.server.serve_forever()

   def add_user(self,user,passwd,loc):
       self.authorizer.add_user(str(user), str(passwd), str(loc), perm='elradfmwM')
