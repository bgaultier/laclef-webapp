laclef-webapp
==============

This is a PHP+MySQL web application for the management of users, devices, door locks, payments, RFID tags.

![laclef webapp](http://laclef.cc/templates/images/arch_en_US.svg)

Debian Installation
-------------------

1. [Install a LAMP server](http://wiki.debian.org/LaMp)
2. [Fork this repo](https://help.github.com/articles/fork-a-repo) 
3. Clone it to your /var/www/ directory
4. Import the database by using this command (please use [this SQL dump](https://raw.github.com/bgaultier/laclef-webapp/master/laclef-webapp.sql)): `$ mysql -u <your_username> -p <your_password> <your_database_name> < laclef-webapp.sql`
5. Modify [settings.php](settings.php) according to your MySQL configuration
6. Fire up your web browser and go to http://localhost/login (login : admin, password : admin)
7. Enjoy a freshly-brewed coffee !

Raspberry Pi guide
------------------
1. [Install a fresh Raspian on your Pi](http://www.raspberrypi.org/downloads)
2. Insert the SD card in your Pi and plug it up
3. Fire up your terminal : `ssh pi@<your_ip_address>` (Default password : raspberry)
4. Once you are logged in, configure the pi : `sudo raspi-config`
5. Upgrade your distro and install the following tools : `sudo su` then `apt-get update && apt-get upgrade`
6. You have time for a coffee break since the upgrade can take a looonnnggg time
7. Install a LAMP server : `apt-get install apache2 php5 mysql-client mysql-server avahi-daemon php5-curl php5-mysql libapache2-mod-php5`
8. 



License
-------

The code is released under The Affero General Public License version 3.
http://www.gnu.org/licenses/agpl-3.0.en.html

