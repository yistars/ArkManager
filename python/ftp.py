# ftp For Arkmanager
# By Bing_Yanchi
# DO NOT CHANGE
import threading,sys,os
import logging
from pyftpdlib.authorizers import DummyAuthorizer, AuthenticationFailed
from pyftpdlib.handlers import FTPHandler
from pyftpdlib.servers import FTPServer
from hashlib import md5

class DummyMD5Authorizer(DummyAuthorizer):
    def validate_authentication(self, username, password, handler):
        if sys.version_info >= (3, 0):
            password = password.encode('latin1')
        hash = md5(password).hexdigest()
        try:
            if self.user_table[username]['pwd'] != hash:
                raise KeyError
        except KeyError:
            raise AuthenticationFailed

class ftp_server(threading.Thread):
   def __init__(self, host, port):
      super(ftp_server, self).__init__(name='ftp_server')
      self.authorizer = DummyMD5Authorizer()
      self.host = host
      self.port = port
       
   def run(self):
      self.handler = FTPHandler
      self.handler.log_prefix = '[FTP] %(remote_ip)s-[%(username)s]'
      self.handler.authorizer = self.authorizer
      self.address = (self.host, self.port)
      self.server = FTPServer(self.address, self.handler)
      self.server.serve_forever()

   def add_user(self,user,passwd,loc):
      self.authorizer.add_user(str(user), str(passwd), str(loc), perm='elradfmwM')

   def del_user(self,user):
      self.authorizer.remove_user(str(user))
