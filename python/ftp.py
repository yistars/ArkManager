# ftp For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import threading
from pyftpdlib.authorizers import DummyAuthorizer
from pyftpdlib.handlers import FTPHandler
from pyftpdlib.servers import FTPServer

class ftp_server(threading.Thread):
    def __init__(self, host, port):
       super(ftp_server, self).__init__(name='ftp_server')
       self.authorizer = DummyAuthorizer()
       self.host = host
       self.port = port
       
    def run(self):
       self.handler = FTPHandler
       self.handler.authorizer = self.authorizer
       self.address = (self.host, self.port)
       self.server = FTPServer(self.address, self.handler)
       self.server.serve_forever()

    def add_user(self,user,passwd,loc):
       self.authorizer.add_user(str(user), str(passwd), str(loc), perm='elradfmwM')
