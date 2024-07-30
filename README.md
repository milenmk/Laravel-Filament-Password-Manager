# Simple Password Manager

Simple password manager written on Laravel and Filament

## Requirements

* PHP > 8.2

* PHP extensions
  * pdo
  * zip
  * mysqli
  * curl
  * mbstring

* MySQL Server 8 OR MariaDB 10
* Apache > 2.4
* Composer
* NPM

## Installation

Create your database and database user

### From the ZIP file and GUI interface

* Download .zip file from GitHub
* Unzip it at folder at your choice

### From a GIT repository

* open terminal and navigate to the folder where you want the script to be installed
* run command `git clone https://github.com/milenmk/Laravel-Filament-Password-Manager.git`

### Final steps

* Using your terminal, navigate to the folder of the app
* rename .env.example to .env
* Fill the database data (server, port, database, user and password)
* Change the `APP_URL` to the actual value
* Optional: change the `APP_NAME`

* Run following commands
  * php artisan key:generate
  * composer install
  * npm install
  * php artisan migrate

## LICENSE

This software is released under the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later version (GPL-3+).

See the [LICENSE](https://github.com/milenmk/Laravel-Filament-Password-Manager/blob/main/LICENSE) file for a full copy of the
license.

## DISCLAIMER

This software and it's code are provided AS IS. Do not use it if you don't know what you are doing.
The author(s) assumes no responsibility or liability for any errors or omissions.
It is NOT recommended to use it on a publicly accessible server!

ALL CONTENT IS “AS IS” AND “AS AVAILABLE” BASIS WITHOUT ANY REPRESENTATIONS OR WARRANTIES OF ANY KIND
INCLUDING THE WARRANTIES OF MERCHANTABILITY, EXPRESS OR IMPLIED TO THE FULL EXTENT PERMISSIBLE BY LAW.
WE, THE AUTHORS, MAKE NO WARRANTIES THAT THE SOFTWARE WILL PERFORM OR OPERATE TO MEET YOUR REQUIREMENTS
OR THAT THE FEATURES PRESENTED WILL BE COMPLETE, CURRENT OR ERROR-FREE. WE, THE AUTHORS, DISCLAIMS ALL
WARRANTIES, IMPLIED AND EXPRESS FOR ANY PURPOSE TO THE FULL EXTENT PERMITTED BY LAW.
