<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="../css/layout.css">
<style>
body{
	background-color:#ffffff;
}
</style>
</head>
<?php
require "global_variable.php";
require "global_function.php";
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
$id_array = array();
$role_array = array();
?>
			
		
<?php

if( isset($_POST['Individual']) ){
	foreach ($_POST['select'] as $key => $value){
//	echo"	<table style=\"width:100%\"  frame=\"box\" border=\"1\"  border-collapse=\"collapse\" >";
//	echo"	<tr>";
//	echo"	<td >Last Name</td>";
//	echo"	<td >First Name</td>";
//	echo"	<td >Email</td>";
//	echo"	<td >Department</td>";
//	echo"	<td >Id</td>";
//	echo"	<td >Role</td>";
//	echo"	</tr>";
//	echo"	<tr>";
		$id_and_Lastname = htmlspecialchars($value);
		list($Lastname,$firstname,$email,$department,$ro,$id) = explode('#',$id_and_Lastname);
		array_push($id_array, $id);
	//	if(strcmp(($_SESSION['role']),"Supervisor")==0){
	//	$sql = " UPDATE `$roles_tbl` SET `Role` = 'Supervisor' WHERE Role_id = '$id'"; 
	//	$update = mysql_query($sql,$conn);
	//	header("Location:overview.php");
	//	}else if(strcmp(($_SESSION['role']),"Super_supervisor")==0){
	//		$sql = " UPDATE `$roles_tbl` SET `Role` = 'Super_supervisor' WHERE Role_id = '$id'"; 
	//		$update = mysql_query($sql,$conn);
	//		header("Location:overview.php");
	//	}else
		if(strcmp(($_SESSION['role']),"Admin")==0){

//		echo"<td >$Lastname</td>";
//		echo"<td >$firstname</td>";
//		echo"<td >$email</td>";
//		echo"<td >$department</td>";
//		echo"<td >$id</td>";
//		echo"<td >$ro</td>";
//		echo"</tr><tr></table>	";
		?>
	
		<center>
		</br>
		<?php
		echo"<caption><b>$Lastname $firstname Department:$department id:$id</b></caption>";
		?>
		</center>
				<table style="width:100%"  frame="box" border="1"  border-collapse="collapse" >
		<tr>
			<th>Type</th>
			<th>Code</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Days Requested</th>
			<th>Status</th>
		</tr>
		<tr>
<?php
 $sql = "SELECT Leave_id,Startdate,Enddate,Status,Approved_by FROM $employee_leave_tbl where Employee_id ='$id' ORDER BY `employee_leave_tbl`.`Startdate`  DESC";
	$request = mysql_query($sql,$conn);
while($leaveinfo = mysql_fetch_array($request)){
$checktype = "SELECT Leave_type FROM $leaves_tbl where Leave_id='$leaveinfo[0]'";
$fetching = mysql_query($checktype,$conn);
	
	// To remove the underscore
	$fetch = mysql_fetch_array($fetching);
	$fetch[0] = str_replace("_", " ", $fetch[0]);
	
	if(strcmp($leaveinfo[0],"HL")==0){
			$days=0.5;
		}else{
			$days=numberofdayswithoutweekends($leaveinfo[1],$leaveinfo[2]);
		}
	echo"   <td>$fetch[0]</td> ";
	echo"   <td>$leaveinfo[0]</td> ";
	echo"   <td>$leaveinfo[1]</td> ";
	echo"   <td>$leaveinfo[2]</td> ";
	echo"	<td>$days</td>		";
	echo"   <td>$leaveinfo[3]</td> ";
	echo"</tr><tr>	";
}
	echo"</table>";
	echo"</br></br>";
?>

			
<?php	
//echo"</table>";
		}
	}
}
else if( isset( $_POST['Group'] ) ){
?>
		</center>
				<table style="width:100%"  frame="box" border="1"  border-collapse="collapse" >
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Name</th>
			<th>Department</th>
			
			<th>Local Leave</th>
			<th>Sick Leave</th>
			<th>Overseas Leave</th>
			<th>Wedding Event</th>
			<th>Half Local</th>
			<th>Maternity Leave</th>
			<th>Paternity Leave</th>
			<th>Total Leaves</th>
		</tr>
		<tr>
<?php
			
		foreach ($_POST['select'] as $key => $value){
			$id_and_Lastname = htmlspecialchars($value);
			list($Lastname,$firstname,$email,$department,$ro,$id) = explode('#',$id_and_Lastname);
			array_push($id_array, $id);
			
			echo"   <td>$id</td> ";
			echo"   <td>MR</td> ";
			echo"   <td>$Lastname $firstname</td> ";
			echo"   <td>$department</td> ";
			
			$Local_Leave = 0;
			$Sick_Leave = 0;
			$Overseas_Leave = 0;
			$Weeding_Event = 0;
			$Half_Local = 0;
			$Maternity_Leave = 0;
			$Paternity_Leave = 0;
			$Total_Leaves = 0;
			$days_approved = 0;
			
			$fetch = "SELECT Amount,Leave_id  FROM $leaves_tbl where Amount IS NOT NULL";
			$fetching = mysql_query($fetch,$conn);
			while($constant_amount = mysql_fetch_array($fetching)){
				
	   
	$checktype = "SELECT Leave_type FROM $leaves_tbl where Leave_id='$constant_amount[1]'";
	    

	$requesting = mysql_query($checktype,$conn);
	// To remove the underscore
	$fetch = mysql_fetch_array($requesting);
	$fetch[0] = str_replace("_", " ", $fetch[0]);
	
	$code = $constant_amount[1];
	$type = $fetch[0];
	$remaining = $constant_amount[0];
	
	//Fetch active leaves

			}
			echo"   <td></td> ";
			echo"	<td></td>";
			echo"   <td></td> ";
			echo"   <td></td> ";
			echo"	<td></td>";
			echo"   <td></td> ";
			echo"   <td></td> ";
			echo"   <td></td> ";
			echo"</tr><tr>	";


}
			echo"</table>";
			echo"</br></br>";
}
	
?>

	
