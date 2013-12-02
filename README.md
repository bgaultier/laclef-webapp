laclef-webapp
==============

This is a PHP+MySQL web application for the management of users, devices, door locks, payments, RFID tags.  and readers with this open-source web-app

![laclef webapp](http://laclef.cc/templates/images/arch_en_US.svg)

Installation
------------

1. [Install a LAMP server](http://wiki.debian.org/LaMp)
2. [Fork this repo](https://help.github.com/articles/fork-a-repo) 
3. Clone it to your /var/www/ directory
4. Import the database by using this command (please use [this SQL dump](https://raw.github.com/bgaultier/laboite-webapp/master/laboite-webapp.sql)): `$ mysql -u <your_username> -p <your_password> <your_database_name> < laclef-webapp.sql`
5. Create an admin user by typing the following MySQL query : 
`$ mysql -u <your_username> -p <your_database> -e "INSERT INTO users (uid, firstname, lastname, email, password, admin, locale) VALUES ('<your_username>', '<your_firstname>', '<your_lastname>', '<your_emailaddress>', SHA1('<your_password>'), '1', 'fr_FR');`
6. Fire up your web browser and go to http://<your_server_adress_or_hostname>/
7. Enjoy a freshly-brewed coffee !

License
-------

The code is released under The Affero General Public License version 3.
http://www.gnu.org/licenses/agpl-3.0.en.html

