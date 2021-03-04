# Comments Administration PHP
* An opensourced software to administer commentsa 
* php application for serving comments
* very jamstack friendly

## getting started
* make sure xamp foulder is working, http://localhost//index.php
  * http://localhost//acme/index.php
  * http://localhost/phpmyadmin/
* simple server `php -S 127.0.0.1:8000`
  * open `http://localhost:8000`
  * need a mysql running, can use docker or one from a shared host
* restart data
  * run `sql/acme-db.sql`, then `sql/acme-data.sql` if you want the dummy data CAREFUL TO NOT RESET EXISTING DATA
     * if your schema doesn't match manually fix the table columns
     * simple db
       * tables: `users,comments,pages,contactForms,configuration`
  * may want to comment dummy data at the bottom

## deploying
* run `sql/acme-db.sql` CAREFUL TO NOT RESET EXISTING DATA against chosen mysql db
  * may want to change the admin user w/ your email
* copy all most files excluding `assets,rest,mail` folders
* copy `cp ./library/connections-backup.php ./library/connections.php`
  * fill out database settings, mail provider, jwt secret
* test working mail form server in `mail` folder
  * copy `mailConfig-back.php mailConfig.php`
  * copy a working mail provider method in the library folder e.g. `cp library/mailFunctions-sendGrid.php library/mailFunctions.php`
* navigate to the website
  * register a new account or use the existing ones
  * if new account change your clientLevel in the users table to 2 or above for admin access

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
* [ ]comment moderation
* [ ]contact form support
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

* uploads folder:

    ### Mac Users
    1. Locate the "uploads" folder in the operating system finder window.
    1. Right-click the folder icon, choose "Get info".
    1. In the new window that opens scroll down and find the "Sharing & Permissions:" area. Expand it if needed to see 1. the options.
    1. Change the privileges for "everyone" to Read & Write.
    1. Close the window.
    1. Repeat these steps for the "images" folder inside of the " uploads" folder.
    1. Repeat these steps for the "images" folder at the root of the Acme site and for the "products" folder within the 1. "images" folder.

    ### Windows Users
    1. Locate the "uploads" folder in the operating system files window.
    1. Right-click the folder icon, choose "Properties".
    1. In the dialog box that opens, click the "Security" tab.
    1. In the name list box, select "Everyone", then make sure the "Modify" option is set to "Allow".
    1. Click "OK".
    1. Close the window.
    1. Repeat these steps for the "images" folder inside of the " uploads" folder.
    1. Repeat these steps for the "images" folder at the root of the Acme site and for the "products" folder within the "images" folder.