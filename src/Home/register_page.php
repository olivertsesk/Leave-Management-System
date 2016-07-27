
<!DOCTYPE html>
<html>
	<head>
<link rel="stylesheet" type="text/css" href="css/layout.css" />
	</head>	
		<body style="background-color:#80d4ff;">
<center>
<h1>
</br>
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</h1>
</center>
<?php

require "global_variable.php";
require "global_function.php";
require "makemenu.php";
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}


createtoolbar();
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];
$department_id  = $_SESSION["department_id"];
?>
<div style ="float:left;margin:10px;">
<form action="register.php" method="POST">
	
	<label>First Name:</label><input type="text" name="firstname"autocomplete="off" ><br></br>
	<label>Last Name:</label><input type="text" name="lastname"autocomplete="off"><br></br>
	<label>Title:</label>
	 <select id="title" name="title">
	 <option value="Mr">Mr.</option>
	 <option value="Mrs">Mrs.</option>
	</select>
	</br></br>
	<label>Employee ID:</label><input type="text" name="employeeid"autocomplete="off"><br></br>
	<label>Email:</label><input type="text" name="email"autocomplete="off"><br></br>
	<label>Role:</label>
	 <select id="role" name="role">
	  <option value="Employee">User</option>
	   <option value="Supervisor">Supervisor</option>
	   <option value="Super_supervisor">Super Supervisor</option>
	</select></br></br>
	<label>Department:</label>
	 <select id="department" name="department">
	 <option value="1">ESS</option>
	 <option value="2">BSS</option>
	  <option value="3">NSS</option>
	  <option value="4">BMS</option>
	   <option value="5">Accounting</option>
	   <option value="6">BTL</option>
	  <option value="7">CDC</option>
	  <option value="8">SST</option>
	</select></br></br>
	<input type="submit" name="submit" value="Register" align="center"></br></br>
	</form>
	</div>
</center>
</body>
</html>

