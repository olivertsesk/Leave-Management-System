<?php
require "../global_variable.php";
require "../global_function.php";
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
	foreach ($_POST['role'] as $key => $value){
			$roles = htmlspecialchars($value);
			echo"$roles";
		//	$sql = " UPDATE `$employee_leave_tbl` SET `Status` = 'Approved',`Approved_by`='$mylastname' WHERE Startdate = '$startdate' AND Employee_id=$id "; 
		//	$update = mysql_query($sql,$conn)
		//$array = unserialize( $id_array );
		//echo "$id_array";
		}

		
?>
