# Asset and Personnel Control System (APCS)

APCS proposes a simplified management of computers assets (hardware details and maintenance services performed) and personnel for small organizations. Developed using PHP, MySQL, HTML5, CSS3 and Javascript/jQuery. The computer asset registration part must be used in conjunction with [AIR](https://github.com/Kevin64/asset-information-and-registration) and [FOP](https://github.com/Kevin64/features-overlay-presentation) software for all its features to work properly.

## Requirements

- **Host OS:** Linux or Windows
- **Web Server:** Apache or IIS
- **PHP version:** 8.2 (with MySQLi extension installed)
- **MySQL version:** 8.0

## Installation

The following instructions will be using Apache as the web server in a Debian-based Linux host. After you install and configure the required software (PHP and MySQL), follow the steps below.
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
6. Modify the `parameters.json` file, entering your `Buildings` list and `HardwareTypes` list. The fields `HostnamePattern`, `AssetNumberDigitLimit`, `SealNumberDigitLimit`, `RoomNumberDigitLimit`, `TicketNumberDigitLimit` and `DeliveryRegistrationNumberDigitLimit` are self-explanatory and you can modify its values according to your business rules. These values will be used by APCS and by [AIR](https://github.com/Kevin64/asset-information-and-registration). More details are included in the file:
```bash
$ sudo nano /var/www/apcs/etc/parameters.json
```
7. Open your browser and type `http://localhost/setup/setup.php` in the address bar, to create the first administrator user.
8. After the admin creation, delete the `setup` folder:
```bash
$ sudo rm -r /var/www/apcs/setup
```
9. Your system is ready to use. Type `http://localhost/index.php` in the address bar, to start using it.

<!--IMPORTANT: [AIR](https://github.com/Kevin64/asset-information-and-registration) and [FOP](https://github.com/Kevin64/features-overlay-presentation) use HTTP Basic Authentication to communicate with APCS. It is strongly recommended to use SSL certificates for encryption, specially for external use.-->
