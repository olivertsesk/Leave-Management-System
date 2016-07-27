<?php
include "global_variable.php";
include "global_function.php";
include "makemenu.php";
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
	<head>

	</head>	
		<body style="background-color:#80d4ff;">
<center>
<h1>
<a href="Homepage.php">
	<img href="Homepage.php" src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</a>
	</h1>

<h2 style="font-family: Verdana, sans-serif;">Welcome to Human Resources Homepage</h2>
</center>
<head>
<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
</head>
<?php
createtoolbar();
?>
</br>
<center>
Sorry Invalid Request!
</center>