![Logo](./images/site/logo.png)

# Comments Administration PHP
* An opensourced software to administer comments
* lightweight php application for serving comments
* very jamstack friendly

## getting started
* make sure xamp foulder is working, http://localhost//index.php
  * http://localhost//acme/index.php
  * http://localhost/phpmyadmin/
* simple server `php -S 127.0.0.1:8000`
  * open `http://localhost:8000`
  * need a mysql running, can use docker or one from a shared host
* docker mysql
 `docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:5.7.29` user: root
* restart data
  * run `sql/acme-db.sql`, then `sql/acme-data.sql` if you want the dummy data CAREFUL TO NOT RESET EXISTING DATA
     * if your schema doesn't match manually fix the table columns
     * simple db
       * tables: `users,comments,pages,contactForms,configuration`
  * may want to comment dummy data at the bottom

## deploying
* pending install scripts and being featured on one click softaculous, manual setup below
* run `sql/acme-db.sql` CAREFUL TO NOT RESET EXISTING DATA against chosen mysql db
  * may want to change the admin user w/ your email
* copy all most files excluding `assets,rest,mail` folders
* copy `cp ./config/connections-backup.php ./config/connections.php`
  * fill out database settings, mail provider, jwt secret
* test working mail form server in `mail` folder
  * copy `mailConfig-back.php mailConfig.php`
  * copy a working mail provider method in the library folder e.g. `cp library/mailFunctions-sendGrid.php library/mailFunctions.php`
* navigate to the website
  * register a new account or use the existing ones
  * if new account change your clientLevel in the users table to 2 or above for admin access

## testing
* `composer install` also see `.github/workflows/unit_tests.yml`
* `php tests/initialize.php` uncomment `resetDb();`
* `./vendor/bin/phpunit` or `.\vendor\bin\phpunit`

## documentation
* see `rest` folder for api endpoints on creating comments and registering

## dependencies
* no composer
* mail
  * you choose
* mysql database
  * can configure for other providers or replace
* php 7


## features
* [x] jwt
  * from https://github.com/adhocore/php-jwt
* [x] configuration flags
* [x] comment moderation
 * [x] approve comments
 * [x] change if moderation needed
* [x] contact form support
  * send contact us messages as api
  * view messages
* [x] api
  * login, register
  * comments
  * form submission
* basic user management
  * reset password
  * [x] change password
  * [x] update display name
  * [x] register user
  * [x] login user
  * [x] view own comments
  * all other functions require a clientLevel > 1, e.g. review comments see messages
* plans for sso (facebook, google)
* [ ] comment filter
  * flagging system?
