# Rwanda Polytechnic Management Project
----------------------------------------
### RMP is the project based on RWANDA POLYTECHNIC students records and the course they are having. 
###DONE BY GIHOZO FABRICE AND TUYISENGE EMMANUEL

HOW TO USE IT
-----------
-DOWNLOAD IT
-CREATE FOLDER IN Htdocs 
-then Paste it in folder you create 
-open xampp and create database 
-import database that is inside
-open browser type localhost/your folder name ex:http://localhost/project/PROJECTRPM/
-I ADD TEMPORARY ADDMIN REGISTER TO HELPS YOU TO ENTER FOR THE FIRST TIME EVEN IF ADMIN REGISTER SHOULD BE HIDDEN 
-AFTER TO ENTER AS ADMIN FIRST ADD THE LIST OF IPRCs
-and ADD MODULATOR TO THE GIVEN IPRCs
-then assign student to these IPRCs
                    
 TOOLS USED
==========

Languages used in Project: PHP
Framework: Codeigniter
Front-end: HTML/CSS, Bootstrap

Features Hierarchy
---------------------
Admin Control Structure
Add Co-Admin / Moderator
View Moderators
Add IPRC
Add Student
View IPRC Students
View Students Details
Edit Students Details
Delete Student
Login/Logout
Moderator Control Structure
----------------------------
Login
View all students Record added by admin
Logout
Control Structure 
-----------------
Administrator :
is like a head for all this who is managing up all the details in the work and managing the records actively.

Dashboard: Which takes admin back to the admin dashboard where ever admin is.
Moderator: To view all moderators added for particular IPRC.
Logout: Logout from the dashboard

Add IPRC : Add college to the database so that it can be dynamically fetched from the database for student IPRC information. Add College Form input includes:
Adding IPRC name
Adding college branch
Add Moderator : Add a moderator for a particular college that means a head of that IPRC. Add Moderator form input includes:
Add Username
Add IPRC name(Dynamically loaded from database)
Email
Gender
Role(Dyanamically loaded from database with role id)
Password
Confirm Password
Add Student : Add Student to the record with different IPRCs. Add Student form input includes:
Add Student Name
Add IPRC name(Dynamically loaded from database)
Email
Gender
Course
