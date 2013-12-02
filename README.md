laclef-webapp
==============

This is a PHP+MySQL web application for the management of users, devices, door locks, payments, RFID tags.

![laclef webapp](http://laclef.cc/templates/images/arch_en_US.svg)

Installation
------------

1. [Install a LAMP server](http://wiki.debian.org/LaMp)
2. [Fork this repo](https://help.github.com/articles/fork-a-repo) 
3. Clone it to your /var/www/ directory
4. Import the database by using this command (please use [this SQL dump](https://raw.github.com/bgaultier/laclef-webapp/master/laclef-webapp.sql)): `$ mysql -u <your_username> -p <your_password> <your_database_name> < laclef-webapp.sql`
5. Modify [settings.php](settings.php) according to your MySQL configuration
6. Fire up your web browser and go to http://localhost/login (login : admin, password : admin)
7. Enjoy a freshly-brewed coffee !

License
-------

The code is released under The Affero General Public License version 3.
http://www.gnu.org/licenses/agpl-3.0.en.html

