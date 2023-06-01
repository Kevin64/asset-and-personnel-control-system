# Asset and Personnel Control System (APCS)

The APCS system proposes a simplified management of IT assets and personnel for small organizations. Developed using PHP 8, MySQL, HTML5, CSS3 and Javascript/jQuery. This system must be used in conjunction with the AIR and FOP softwares for all its features to work properly.

## Requirements

- **Host OS:** Linux or Windows
- **Web Server:** Apache or IIS
- **PHP version:** 8.0 (with MySQLi extension installed)
- **MySQL version:** 8.0

## Installation

The following instructions will be using Apache as the web server in a Debian-based Linux host. After you install and configure the required software, follow the steps below.
1. Download the [latest release](https://github.com/Kevin64/asset-and-personnel-control-system/releases/latest) package into a folder (e.g. Downloads).
2. Open the terminal and type:
```bash
$ cd Downloads
$ sudo mkdir /var/www/apcs
$ sudo unzip APCS* -d /var/www/apcs
$ sudo cp /var/www/apcs/etc/db-config-defaults.json /var/www/apcs/etc/db-config.json
$ sudo cp /var/www/apcs/etc/parameters-defaults.json /var/www/apcs/etc/parameters.json
$ sudo mysql -u root -p
mysql> CREATE DATABASE IF NOT EXISTS apcsdb;
mysql> exit
$ sudo mysql -u root -p apcsdb < /var/www/apcs/database/database.sql
$ sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/apcs.conf
```
3. Open `apcs.conf` file and copy the contents below into it, modifying the server port, ServerAdmin, and other virtual host details if desired:
```bash
$ sudo nano /etc/apache2/sites-available/apcs.conf
```
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/apcs
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
4. Disable the default Apache site and enable APCS' one:
```bash
$ sudo a2dissite 000-default.conf
$ sudo a2ensite apcs.conf
$ sudo systemctl restart apache2
```
5. Modify the `db-config.json` file, entering your database access credentials in `DbSettings`, organization identity data in `OrgData` and `Locale`:
```bash
$ sudo nano /var/www/apcs/etc/db-config.json
```
6. Modify the `parameters.json` file, entering your `Buildings` list and `HardwareTypes` list. The default values for `FirmwareTypes`, `TpmTypes`, `MediaOperationTypes`, `SecureBootStates`, `VirtualizationTechnologyStates` and `ServiceType` covers a good chunk of real world possibilities, and it is not recommended changing it, because [AIR](https://github.com/Kevin64/asset-information-and-registration) depends on these values:
```bash
$ sudo nano /var/www/apcs/etc/parameters.json
```
7. Set permissions for `/var/www/apcs/output`, allowing [AIR](https://github.com/Kevin64/asset-information-and-registration) to generate JSON files:
```bash
$ sudo chmod 777 /var/www/apcs/output/
```
8. Open your browser and type `http://localhost/setup/setup.php` in the address bar, to create the first administrator user.
9. After the admin creation, delete the `setup` folder:
```bash
$ sudo rm -r /var/www/apcs/setup
```
10. Your system is ready to use. Type `http://localhost/index.php` in the address bar, to start using it.
