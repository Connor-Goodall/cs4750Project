# cs4750Project
* Make sure that you alter the user table to include the password variable by using ALTER TABLE `User` ADD Password VARCHAR(100);
* Also, make sure that you add a password for the users you plan on logging on with in the `User` table.
* Be sure to add your connect-db.php file to the same directory before deploying on the sqlserver
* Make sure to add ON DELETE CASCADE by using ALTER TABLE ADD CONSTRAINT to every table that has the student or faculty computing id as a foreign key 
(like this: ALTER TABLE `Leads` ADD CONSTRAINT delete_Student_Leads FOREIGN KEY(computing_id) REFERENCES `Student`(computing_id) ON DELETE CASCADE)
