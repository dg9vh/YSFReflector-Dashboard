# YSFReflector-Dashboard
Dashboard for YSFReflector (by G4KLX)
=====================================

THIS CODE IS NO LONGER UNDER DEVELOPMENT!!!

About
=====
YSFReflector-Dashboard is a web-dashboard for visualization of different data like
system temperatur, cpu-load ... and it shows a last-heard-list.

It relies on YSFReflector by G4KLX (see https://github.com/g4klx/YSFClients). At 
this place a big thank you to Jonathan for his great work he did with this 
software.

Required are
============
* Webserver like 
* lighttpd or apache(2)
* at least PHP 5 >= 5.5.0

Installation
============
* Please ensure to not put loglevels at 0 in YSFReflector.ini.
* Copy all files into your webroot and enjoy working with it.
* Create a config/config.php by calling setup.php and giving suitable values
* If Dashboard is working, remove setup.php from your webroot

For detailled installation see `linux-step-by-step.md` within this repository.

Note
============
* You might need to implement a logrotate mechanism for the YSFReflector log files to prevent it to fill your filesystem. This directory is normally configured with 'FilePath=' in /etc/YSFReflector.ini


Contact
=======
Feel free to contact the author via email: dg9vh@darc.de
