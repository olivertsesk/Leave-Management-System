<?php
require "global_variable.php";
require "global_function.php";
require "notification_email.php";
require "makemenu.php";
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}		
$id 		=$_SESSION['id'];
$email		=$_SESSION['email'];


$role					=$_SESSION["role"] ;		
$department_id			=$_SESSION["department_id"] ;
$lastname				=$_SESSION["lastname"];
$firstname				=$_SESSION["Firstname"]; 	

$locall		= $_SESSION['ll'];
$overseasl	= $_SESSION['ol'];
$sickl 		=$_SESSION['sl'];

//values from calender.php
$startdate 	 = $_POST['startdate'];
$enddate	 = $_POST['enddate'];
$reason		 = $_POST['reason'];

	
?>

<?php
//Establise connection
$conn = connecttodatabase();
   mysql_select_db($database);
   
if(strcmp($startdate,"") == 0 || strcmp($enddate,"") == 0){
	header("Location:rejectdays.php");
	die();
	return true;
}
$numberofdaysrequested = numberofdayswithoutweekends($startdate,$enddate);
if(strcmp($reason,"HL")==0 && strcmp($startdate,$enddate)==0){
	$insert = "INSERT INTO `$employee_leave_tbl` (Employee_id,Leave_id,Startdate,Enddate) VALUES ('$id','$reason','$startdate','$enddate')";
    $inserting = mysql_query($insert,$conn);
	daysrequested($id,$lastname,$firstname,$department_id,$role);
    header("Location:Homepage.php");
	die();
	return true;
}
//only if start and end dates are equal
if(strcmp($reason,"HL")==0){
	header("Location:rejectdays.php");
	return true;
}
else if(strcmp($reason,"LL") == 0 && $locall >= $numberofdaysrequested ){
	$insert = "INSERT INTO `$employee_leave_tbl` (Employee_id,Leave_id,Startdate,Enddate) VALUES ('$id','$reason','$startdate','$enddate')";
    $inserting = mysql_query($insert,$conn);
	daysrequested($id,$lastname,$firstname,$department_id,$role);
    header("Location:Homepage.php");
	return true;
}
else if(strcmp($reason,"OL") == 0 && $overseasl >= $numberofdaysrequested ){
	$insert = "INSERT INTO `$employee_leave_tbl`(Employee_id,Leave_id,Startdate,Enddate) VALUES ('$id','$reason','$startdate','$enddate')";
    $inserting = mysql_query($insert,$conn);
	daysrequested($id,$lastname,$firstname,$department_id,$role);
	header("Location:Homepage.php");
	return true;
}
else if(strcmp($reason,"SL") == 0 && $sickl >= $numberofdaysrequested ){
	$insert = "INSERT INTO `$employee_leave_tbl`(Employee_id,Leave_id,Startdate,Enddate) VALUES ('$id','$reason','$startdate','$enddate')";
    $inserting = mysql_query($insert,$conn);
	header("Location:Homepage.php");
	return true;
}
else if(!(strcmp($reason,"LL")==0 ||strcmp($reason,"OL")==0||strcmp($reason,"SL")==0)){
	$insert = "INSERT INTO `$employee_leave_tbl`(Employee_id,Leave_id,Startdate,Enddate) VALUES ('$id','$reason','$startdate','$enddate')";
    $inserting = mysql_query($insert,$conn);
	daysrequested($id,$lastname,$firstname,$department_id,$role);
	header("Location:Homepage.php");
	return true;
}else{
	header("Location:rejectdays.php");
	return true;
}
    mysql_close($conn);
?>
