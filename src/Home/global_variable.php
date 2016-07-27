
<?php
//This is a declaration file for sql tables
//require "global_variable.php";

//Autentication for php script
$autenticate = 'id';

//Type of roles ascending permission
$Level_0 		= "User";

$Level_1		= "Supervisor";

$Level_2		= "Super_supervisor";

//ultimate user
$admin 				= "Admin";


//DATABSE INFORMATION
//database host
$dbhost = 'localhost:3306';

//database username
$dbuser = 'root@localhost';

//database password
$dbpass = 'admin1234';

//database used
$database = 'test';

//SQL INFORMATION
//contain all users with Name,Email,Department,Role,Password,Counter
$employee_tbl   			= "employee_tbl";

$department_tbl 			= "department_tbl";

$employee_department_tbl	= "employee_department_tbl";

$leaves_tbl					= "leaves_tbl";

$roles_tbl					= "roles_tbl";

$employee_leave_tbl			= "employee_leave_tbl";

$holidays_tbl				="holidays_tbl";
?>