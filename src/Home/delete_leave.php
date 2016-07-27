<?php
require "../global_variable.php";
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}
$id = $_SESSION['id'];
$conn = mysql_connect($dbhost, $dbuser);

	mysql_select_db($database);
    if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }  
foreach ($_POST['startdate'] as $key => $value){
	$startdate = htmlspecialchars($value);
	$sql ="UPDATE $employee_leave_tbl SET `Status`='Unrequested' WHERE Employee_id = '$id' AND Startdate = '$startdate' ";
	$request = mysql_query($sql,$conn);
	 if(!$request ) {
      die('Could not connect: ' . mysql_error());
   }  
}
	header("Location:Homepage.php");
	die();
	return true;

?>