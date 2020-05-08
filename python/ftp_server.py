# FTP Server
# By Bing_Yanchi
class ftp_server:
   def __init__(self):
       self.authorizer = DummyAuthorizer()
       self.authorizer.add_user('admin', 'password', '.', perm='elradfmwM')

   def run(self):
       self.handler = FTPHandler
       self.handler.authorizer = self.authorizer
       self.address = ('localhost', 21)
       self.server = FTPServer(self.address, self.handler)
       logging.basicConfig(filename='pyftpd.log', level=logging.INFO)
       self.server.serve_forever()

   def add_user(self,user,passwd,loc,privi):
       self.authorizer.add_user(str(user), str(passwd), str(loc), perm=str(privi))