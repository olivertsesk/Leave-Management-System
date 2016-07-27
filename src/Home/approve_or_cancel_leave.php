<?php
require "global_variable.php";
require "global_function.php";
require "notification_email.php";
session_start();

if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}


$id = $_SESSION['id'];
$conn = connecttodatabase();
   if(! $conn ) {
     die('Could not connect: ' . mysql_error());
	}

$mylastname = getlastnamefromid($id);
if( isset($_POST['select']) ){
	foreach ($_POST['select'] as $key => $value){
		
			$id_and_Startdate = htmlspecialchars($value);
			list($id,$startdate) = explode('#',$id_and_Startdate);
		if ( isset( $_POST['Approve'] ) ) {
			$sql = " UPDATE `$employee_leave_tbl` SET `Status` = 'Approved',`Approved_by`='$mylastname' WHERE Startdate = '$startdate' AND Employee_id=$id "; 
			$update = mysql_query($sql,$conn);
			daysapproved($id);	
		}
		else if ( isset( $_POST['Cancel'] ) ) {
			$sql = " UPDATE `$employee_leave_tbl` SET `Status` = 'Cancelled' WHERE Startdate = '$startdate' AND Employee_id=$id "; 
			$update = mysql_query($sql,$conn);
			daysnotapproved($id);
		}
			header("Location:Homepage.php");
		}
}else{
	echo"Nothing has been selected";
}

?>
