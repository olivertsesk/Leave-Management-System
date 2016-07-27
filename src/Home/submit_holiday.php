<?php
include "global_variable.php";
include "global_function.php";
$conn = connecttodatabase();

$decsription 	 = $_POST['description'];
$date	 		 = $_POST['datepicker'];

echo"$date";
$sql = "INSERT INTO `$holidays_tbl` (`Description`, `Date`) VALUES ('$decsription', '$date')";
$request = mysql_query($sql,$conn);
	header("Location:holidays.php");
?>