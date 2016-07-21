#How to install a YSFReflector

The following howto quickly describes the installation and configuration of a YSFReflector-system
First of all you'll need to get a copy of the sources. This is recommended to do with git as following:

git clone https://github.com/g4klx/YSFClients.git

This copies the actual sources of the whole YSFClients-Project into a folder "YSFClients". Within this directory you'll find a folder "YSFReflector". cd into it and simply do

make clean all

A minute later the compile-process is done and you got an executable file "YSFReflector".

Within the directory you also got a YSFReflector.ini that you have to customize to your own needs. Fill in there following:

Name=Your Reflector's name
Description=Your Reflector's description
There is also a line

Daemon=1
that forces the reflector-executable to run as a deamon after startup. For this you'll need to setup a user "mmdvm" on your linux-system. This can be done with:

groupadd mmdvm
useradd mmdvm -g mmdvm -s /sbin/nologin
As a last instance of installation, you may want to have the services started automatically at bootup of your server. Therefore you'll need a startup-script. Mine is

/etc/init.d/YSFReflector.sh
and has following content:

\#!/bin/bash
\### BEGIN INIT INFO
\#
\# Provides:             YSFReflector
\# Required-Start:       $all
\# Required-Stop:        
\# Default-Start:        2 3 4 5
\# Default-Stop:         0 1 6
\# Short-Description:    Example startscript YSFReflector

\#
\### END INIT INFO
\## Fill in name of program here.
PROG="YSFReflector"
PROG_PATH="/usr/local/bin/"
PROG_ARGS="/etc/YSFReflector.ini"
PIDFILE="/var/run/YSFReflector.pid"
USER="root"

start() {
      if [ -e $PIDFILE ]; then
          \## Program is running, exit with error.
          echo "Error! $PROG is currently running!" 1>&2
          exit 1
      else
          cd $PROG_PATH
          ./$PROG $PROG_ARGS
          echo "$PROG started"
          touch $PIDFILE
      fi
}

stop() {
      if [ -e $PIDFILE ]; then
          \## Program is running, so stop it
         echo "$PROG is running"
         rm -f $PIDFILE
         killall $PROG
         echo "$PROG stopped"
      else
          \## Program is not running, exit with error.
          echo "Error! $PROG not started!" 1>&2
          exit 1
      fi
}

\## Check to see if we are running as root first.
\## Found at
\## http://www.cyberciti.biz/tips/shell-root-user-check-script.html
if [ "$(id -u)" != "0" ]; then
      echo "This script must be run as root" 1>&2
      exit 1
fi

case "$1" in
      start)
          start
          exit 0
      ;;
      stop)
          stop
          exit 0
      ;;
      reload|restart|force-reload)
          stop
          sleep 5
          start
          exit 0
      ;;
      **)
          echo "Usage: $0 {start|stop|reload}" 1>&2
          exit 1
      ;;
esac
exit 0
\### END
		
As you can see on top of the script, my binary is located in /usr/local/bin (where I copied it after compile) and my YSFReflector.ini is in /etc

Do it similar to be in standard.

To enable the service simply call

chkconfig YSFReflector.sh on
Then all would be starting on boot-time.

Hope you could follow all steps. It is recommended to do these as root :-)