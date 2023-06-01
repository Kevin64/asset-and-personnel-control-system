# Asset and Personnel Control System (APCS)

The APCS system proposes a simplified management of IT assets and personnel for small organizations. Developed using PHP 8, MySQL, HTML5, CSS3 and Javascript/jQuery. This system must be used in conjunction with the AIR and FOP softwares for all its features to work properly.

## Requirements

- Linux or Windows
- Apache or IIS (with PHP extensions)
- PHP 8.0
- MySQL 8.0

## Installation

The following instructions will be using Apache as the web server in a Linux host. After you install and configure the required software, follow the steps below.
1. Download the latest release package into a folder (e.g. Downloads).
2. Open the terminal and type:
```bash
$ cd Downloads
$ sudo mkdir /var/www/apcs
$ sudo unzip APCS* -d /var/www/apcs
$ sudo cp /var/www/apcs/etc/db-config-defaults.json /var/www/apcs/etc/db-config.json
$ sudo cp /var/www/apcs/etc/parameters-defaults.json /var/www/apcs/etc/parameters.json
$ sudo mysql -u root -p
mysql> CREATE DATABASE IF NOT EXISTS apcs;
mysql> exit
$ sudo mysql -u root -p apcs < /var/www/apcs/database/database.sql
$ sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/apcs.conf
$ sudo nano /etc/apache2/sites-available/apcs.conf
```
3. Copy the content below into the `apcs.conf` file, modifying the server port, ServerAdmin, and other virtual host details as desired.
```xml
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/apcs
    <FilesMatch ".+\.ph(ar|p|tml)$">
        SetHandler "proxy:unix:/run/php/php8.0-fpm.sock|fcgi://localhost"
    </FilesMatch>
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
4. Back in the terminal
```bash
$ sudo a2dissite 000-default.conf
$ sudo a2ensite apcs.conf
$ sudo systemctl restart apache2
```

6. Open your browser and type `http://localhost/setup/setup.php` in the address bar, to create the first administrator user.
7. After the admin creation, delete the `setup` folder.
```bash
$ sudo rmdir /var/www/apcs/setup
```
