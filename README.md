# Rwanda Polytechnic Management Project
----------------------------------------
### RMP is the project based on RWANDA POLYTECHNIC students records and the course they are having. 
Clone it and try to find out the intersting features inside.

Languages used in Project: PHP
Framework: Codeigniter
Front-end: HTML/CSS, Bootstrap

# Read More About Codeigniter in Readme.rst file

Features Hierarchy
---------------------
Admin Control Structure
Add Co-Admin / Moderator
View Moderators
Add College
Add Student
View College Students
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
Moderator: To view all moderators added for particular college.
Logout: Logout from the dashboard

Add College : Add college to the database so that it can be dynamically fetched from the database for student college information. Add College Form input includes:
Adding college name
Adding college branch
Add Moderator : Add a moderator for a particular college that means a head of that college. Add Moderator form input includes:
Add Username
Add College name(Dynamically loaded from database)
Email
Gender
Role(Dyanamically loaded from database with role id)
Password
Confirm Password
Add Student : Add Student to the record with different college. Add Student form input includes:
Add Student Name
Add College name(Dynamically loaded from database)
Email
Gender
Course
