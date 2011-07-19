Dynamic Text Plugin
===================

Purpose
-------
Show a dynamic chunk of text based on the presence of a query string value or cookie. Dynamic value is saved from session to session in a cookie.

Possible uses
-------------
If you have geographically targeted Google AdWords campaigns, you can show a different phone number based on which ad they clicked.

Installation
------------
* Download the latest code from github
* If this is a new install, create a new configuration.php file (You can use configuration.example.php as a template)
* Upload the plugin, including configuration, to your plugins directory (usually wp-content/plugins)
* Enable the plugin from wp-admin

To-do items
-----------
* Store the configuration data in a database instead of a PHP array
* Expose the configuration data in the WP admin
* Allow more complex match strings than exact matches
* Allow configuration of cookie persistence