import threading
from pyftpdlib.authorizers import DummyAuthorizer
from pyftpdlib.handlers import FTPHandler
from pyftpdlib.servers import FTPServer

class ftp_server(threading.Thread):
   def __init__(self):
       super(ftp_server, self).__init__(name='ftp_server')
       self.authorizer = DummyAuthorizer()
       self.authorizer.add_user('admin', 'password', '.', perm='elradfmwM')
       
   def run(self):
       self.handler = FTPHandler
       self.handler.authorizer = self.authorizer
       self.address = ('localhost', 21)
       self.server = FTPServer(self.address, self.handler)
       self.server.serve_forever()

   def add_user(self,user,passwd,loc,privi):
       self.authorizer.add_user(str(user), str(passwd), str(loc), perm=str(privi))


ftp_server().start
ftp_server.add_user('user','password',".",'elradfmwM').run