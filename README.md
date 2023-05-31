# Asset and Personnel Control System (APCS)

The APCS system proposes a simplified management of IT assets and personnel for small organizations. Developed using PHP 8, MySQL, HTML5, CSS3 and Javascript/jQuery. This system must be used in conjunction with the AIR and FOP softwares for all its features to work properly.

## Requirements

- Linux or Windows
- Apache or IIS (with PHP extensions)
- PHP 8.0
- MySQL 8.0

## Installation

The following instructions will be using Apache as the web server in a Linux host. After you install and configure the required software, follow the steps below.
1. Download the latest release package.
2. Open the terminal and type:
  - $ cd Downloads
  - $ sudo mkdir /var/www/apcs
  - $ sudo unzip APCS* -d /var/www/apcs
  - $ sudo mysql -u root -p
  - mysql> CREATE DATABASE IF NOT EXISTS apcs;
  - mysql> exit
  - $ sudo mysql -u root -p apcs < /var/www/apcs/database/database.sql
  - 
3. 
