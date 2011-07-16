Dynamic Text Plugin
===================

Purpose
-------
Show a dynamic chunk of text based on the presence of a query string value or cookie. Dynamic value is saved from session to session in a cookie.

Possible uses
-------------
If you have geographically targeted Google AdWords campaigns, you can show a different phone number based on which ad they clicked.

To-do items
-----------
* Store the configuration data in a database instead of a PHP array
* Expose the configuration data in the WP admin
* Allow more complex match strings than exact matches
* Allow configuration of cookie persistence