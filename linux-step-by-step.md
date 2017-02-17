# Linux Step-By-Step
This short howto describes step-by-step how to install the YSFReflector-Dashboard on a system using a Debian Linux distribution.

##Installation Steps
1. Update your system:

	>sudo apt-get update && sudo apt-get upgrade

2. Install a webserver:

	>sudo apt-get install apache2

3. Create a group for the webserver and add yourself to it:

	>sudo groupadd www-data

	>sudo usermod -G www-data -a <username>
	
4. Set permissions so you and the webserver have full access to the files:

	If you use a current Debian Jessie, use following commands:

	>sudo chown -R www-data:www-data /var/www/html

	>sudo chmod -R 775 /var/www/html

	If you use a Debian Wheezy use:

	>sudo chown -R www-data:www-data /var/www

	>sudo chmod -R 775 /var/www

5. Install PHP5 and enable the required modules:

	>sudo apt-get install php5-common php5-cgi php5

6. To install the dashboard you should use git for easy updates:

	>sudo apt-get install git

7. Now you can clone the dashboard into your home directory:

	>cd ~
	
	>git clone https://github.com/dg9vh/YSFReflector-Dashboard.git

8. Next, you need to copy the files into the webroot so they can be served by apache2:

	If you are using Debian Jessie, run:

	>sudo cp -R /home/<username>/YSFReflector-Dashboard/* /var/www/html/	

	If you are using Debian Wheezy, run:

	>sudo cp -R /home/<username>/YSFReflector-Dashboard/* /var/www/

9. To make sure the dashboard is served instead of the default "index.html", cd into the webroot /var/www/html respectively /var/www and remove that file:

	>sudo rm index.html

10. Finally, you need to configure the dashboard by pointing your browser to http://IP-OF-YOUR-YSFREFLECTOR/setup.php . This will create /var/www/html/config/config.php respectively /var/www/config/config.php which contains your custom settings. 

Now the dashboard should be reachable via http://IP-OF-YOUR-YSFREFLECTOR/

##Configuration Of Dashboard
When configuring the dashboard, make sure to set the correct paths for logs etc. If they are wrong, no last-heard or similar information will be shown on the dashboard!
