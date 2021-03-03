## getting started
* make sure xamp foulder is working, http://localhost//index.php
  * http://localhost//acme/index.php
  * http://localhost/phpmyadmin/
* simple server `php -S 127.0.0.1:8000`
  * open `http://localhost:8000`
  * need a mysql running, can use docker or one from a shared host
* restart data
  * run `sql/acme-db.sql`
  * may want to comment dummy data at the bottom

## features
* configuration flags
* comment moderation
* receive contact us as rest api and view messages
* basic user management
  * reset password
  * change password
  * update display name
  * register user
  * login user
  * view own comments
  * all other functions require a clientLevel > 1, e.g. review comments see messages
* plans for sso (facebook, google)

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