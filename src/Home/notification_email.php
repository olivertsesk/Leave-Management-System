<?php

include "logging.php";

function daysrequested($id_of_user,$lastname,$firstname,$department_id,$role){
	include "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);	
	mysql_select_db($database);
	$emails = find_email_of_supervisor($id_of_user,$department_id,$role);
	foreach ($emails as $email) {
	echo"$email";
		$to = "$email";
		$subject = "Manager Leave";
		$txt = "This is an email to inform you that $lastname $firstname has pending request. ";
		$headers = "From: webmaster@birger.technology" . "\r\n";
		mail($to,$subject,$txt,$headers);
		logging($id_of_user,notify ." ".$to);
		logging($id_of_user,"request days off");
	}
}
function daysapproved($id_of_user){
	include "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);	
	mysql_select_db($database);
	$get_email ="SELECT Email FROM employee_tbl WHERE Employee_id = '$id_of_user' ";
	$getting_email = mysql_query($get_email,$conn);
	$row = mysql_fetch_array($getting_email);
	
		$to = "$row[0]";
		$subject = "Manager Leave";
		$txt = "This is an email to inform you that your leave has been approved. ";
		$headers = "From: webmaster@birger.technology" . "\r\n";
		mail($to,$subject,$txt,$headers);
		$myid= $_SESSION["id"] ;
		logging($myid,$to);
		logging($myid,"approve leave of '$id_of_user'");
}
function daysnotapproved($id_of_user){
	include "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);	
	mysql_select_db($database);
	$get_email ="SELECT Email FROM employee_tbl WHERE Employee_id = '$id_of_user' ";
	$getting_email = mysql_query($get_email,$conn);
	$row = mysql_fetch_array($getting_email);
	
		$to = "$row[0]";
		$subject = "Manager Leave";
		$txt = "This is an email to inform you that your leave has been disapproved. ";
		$headers = "From: webmaster@birger.technology" . "\r\n";
		mail($to,$subject,$txt,$headers);
		$myid= $_SESSION["id"] ;
		logging($myid,$to);
		logging($myid,"cancel leave of '$id_of_user'");
}


function find_email_of_supervisor($id_of_user,$department_id,$role){
	include "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);	
	mysql_select_db($database);
	  //if user -->result supervisor
	if(strcmp($role,$Level_0) ==0){
		
		$get_id_of_supervisor="SELECT Role_id FROM `employee_department_tbl` JOIN 
		roles_tbl on employee_department_tbl.Employee_id=roles_tbl.Role_id 
		where Department_id='$department_id' AND roles_tbl.Role='Supervisor'";
		
		$getting_id_of_supervisor = mysql_query($get_id_of_supervisor,$conn);
			
		$emails = array();
	   while($row = mysql_fetch_array($getting_id_of_supervisor)){
		   $get_email_of_supervisor="SELECT Email FROM `$employee_tbl` WHERE Employee_id='$row[0]'";
		   $getting_email_of_supervisor = mysql_query($get_email_of_supervisor,$conn);
		   $row1 = mysql_fetch_array($getting_email_of_supervisor);
		   $emails[]=$row1[0];
		}
		return  $emails;
	}
	//if supervisor -->result super_supervisor
	if(strcmp($role,$Level_1) ==0){
		
		$get_id_of_supervisor="SELECT Role_id FROM `$employee_department_tbl` JOIN 
		roles_tbl on employee_department_tbl.Employee_id=roles_tbl.Role_id WHERE roles_tbl.Role='Super_supervisor'";
		
		$getting_id_of_supervisor = mysql_query($get_id_of_supervisor,$conn);
		
		
		$emails = array();
	   while($row = mysql_fetch_array($getting_id_of_supervisor)){
		   $get_email_of_supervisor="SELECT Email FROM `employee_tbl` WHERE Employee_id='$row[0]'";
		   $getting_email_of_supervisor = mysql_query($get_email_of_supervisor,$conn);
		   $row1 = mysql_fetch_array($getting_email_of_supervisor);
		   $emails[]=$row1[0];
		}
				   return  $emails;
	}
}


?>