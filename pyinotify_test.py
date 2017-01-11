import pyinotify
import subprocess
import re
import time

class MyEventHandler(pyinotify.ProcessEvent):

    def process_IN_CREATE(self, event):
        if event.dir:
            print ("dir IN_CREATE event:", event.pathname)
            time.sleep(5)
            subprocess.run(["php new.php DIR ADD " + re.escape(event.pathname)], shell=True)
        else:
            print ("IN_CREATE event:", event.pathname)
            subprocess.run(["php new.php FILE ADD " + re.escape(event.pathname)], shell=True)

    def process_IN_DELETE(self, event):
        if event.dir:
            print ("dir IN_DELETE event:", event.pathname)
            subprocess.run(["php new.php DIR DELETE " + re.escape(event.pathname)], shell=True)
        else:
            print ("IN_DELETE event:", event.pathname)
            subprocess.run(["php new.php FILE DELETE " + re.escape(event.pathname)], shell=True)

    def process_IN_MODIFY(self, event):
        if event.dir:
            print ("dir IN_MODIFY event:", event.pathname)
        else:
            print ("IN_MODIFY event:", event.pathname)

    def process_IN_MOVED_TO(self, event):
        if event.dir:
            print ("dir IN_MOVED_TO event:", event.pathname)
        else:
            print ("IN_MOVED_TO event:", event.pathname)
        # subprocess.run(["php update_database.php " + event.pathname], shell=True)        


def main():
    # watch manager
    wm = pyinotify.WatchManager()
    wm.add_watch('Test_Dir', pyinotify.ALL_EVENTS, rec=True)

    # event handler
    eh = MyEventHandler()

    # notifier
    notifier = pyinotify.Notifier(wm, eh)
    notifier.loop()

if __name__ == '__main__':
    main()