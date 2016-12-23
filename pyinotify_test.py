import pyinotify
import subprocess

class MyEventHandler(pyinotify.ProcessEvent):

    def process_IN_CREATE(self, event):
        subprocess.run(["php update_database.php " + event.pathname], shell=True)

    def process_IN_DELETE(self, event):
        subprocess.run(["php update_database.php " + event.pathname], shell=True)

    # def process_IN_MODIFY(self, event):
    #     print ("MODIFY event:", event.pathname)

    def process_IN_MOVED_TO(self, event):
        subprocess.run(["php update_database.php " + event.pathname], shell=True)        

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