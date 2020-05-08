import thread
import ftp_server

this_ftp = create_ftp_server.ftp_server()

thread.start_new_thread(this_ftp.run,())
thread.start_new_thread(this_ftp.add_user,('user','password',".",'elradfmwM'))