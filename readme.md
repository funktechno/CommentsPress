## getting started

* make sure xamp foulder is working, http://localhost//index.php
  * http://localhost//acme/index.php
  * http://localhost/phpmyadmin/
* simple server `php -S localhost:8000`
  * open `http://localhost:8000`
* restart data
  * run `sql/acme-db.sql` then `sql/inventory.sql`
* acme-db.sql setup
  Uncomment the following lines:
    Lines 125 through 134
    Lines 141 and 142
    Lines 147 and 148
* extensions
  * [Web Developer](https://chrome.google.com/webstore/detail/web-developer/bfbameneiokkgbdmiekhjnmfkcnldhhm?hl=en-US)

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