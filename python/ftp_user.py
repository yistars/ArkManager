import _thread
import ftp_server

this_ftp = ftp_server.ftp_server()

_thread.start_new_thread(this_ftp.run,())
_thread.start_new_thread(this_ftp.add_user,('user','password',"C://",'elradfmwM'))