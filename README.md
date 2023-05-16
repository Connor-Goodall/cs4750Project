# Club Hub
deploying on XAMPP

Instructions on deploying to xampp: https://www.cs.virginia.edu/~up3f/cs4640/supplement/basic-deployment.html#section1

For local deployment, Use your command line to navigate to your xampp/htdocs folder and type "git clone https://github.com/Connor-Goodall/cs4750Project" (HTTPS) or "git clone git@github.com:Connor-Goodall/cs4750Project.git" (SSH) into the command line in order to place the folder in the correct spot for deployment.

To setup the database, follow the instructions on accessing phpMyAdmin, adding a user, creating a database (name the database clubhub), and importing a SQL file (import the SQL file clubhub.sql from the cs4750Project folder): https://www.cs.virginia.edu/~up3f/cs4750/supplement/DB-setup-xampp.html#section2

Once done, add your username and password that you created in the instructions for adding a user to the "PHP (on GCP, local XAMPP, or CS server) connect to MySQL (on local XAMPP)" section in the connect-db.php file from the cs4750Project folder

Once the xampp app on is opened on your computer and the apache webserver and the mysql database is started, the app can be viewed through your webbrowser at http://localhost/cs4750Project/index.php
