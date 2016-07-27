<?php

include "global_variable.php";
include "global_function.php";
include "makemenu.php";
include "notification_email.php";
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
	<link rel="stylesheet" href="../css/table.css">
	<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<style>


h3 {
	 font-size: 36px; 
  font-size: 1.0vw;
}


	/* 
	Max width before this PARTICULAR table gets nasty
	This query will take effect for any screen smaller than 760px
	and also iPads specifically.
	*/
	@media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
	
		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr { 
			display: block; 
		}
		
		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr { 
			position: absolute;
			top: -9999px;
			left: -9999px;
		}
		
		tr { border: 1px solid #ccc; }
		
		td { 
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee; 
			position: relative;
			padding-left: 50%; 
		}
		
		td:before { 
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%; 
			padding-right: 10px; 
			white-space: nowrap;
		}
		
		/*
		Label the data
		*/
		.table1 td:nth-of-type(1):before { content: "Type"; }
		.table1 td:nth-of-type(2):before { content: "Code"; }
		.table1 td:nth-of-type(3):before { content: "Start Date"; }
		.table1 td:nth-of-type(4):before { content: "End Date"; }
		.table1 td:nth-of-type(5):before { content: "Days Requested"; }
		.table1 td:nth-of-type(6):before { content: "Status"; }
		.table1 td:nth-of-type(7):before { content: "Select"; }
	}
	
	/* Smartphones (portrait and landscape) ----------- 
	@media only screen
	and (min-device-width : 320px)
	and (max-device-width : 480px) {
		body { 
			padding: 0; 
			margin: 0; 
			width: 320px; }
		}*/
	
	/* iPads (portrait and landscape) ----------- 
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		body { 
			width: 900px; 
		}
	}*/
	</style>
	</head>
		
<center>
</br>
	<img href="Homepage.php" src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	

<h3 style="font-family: Verdana, sans-serif;">Welcome to Human Resources Homepage</h3>
</center>
<?php
createtoolbar();
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];
$department_id  = $_SESSION["department_id"];
?>

<?php
	$conn = connecttodatabase();
    $sql = "SELECT Leave_id,Startdate,Enddate,Status,Approved_by FROM $employee_leave_tbl where Employee_id ='$id' ORDER BY `employee_leave_tbl`.`Startdate`  DESC";
	$request = mysql_query($sql,$conn);
?>
<!-<form action = "delete_leave.php" method = "post">
<div id="page-wrap">

<center>
 <caption><b>My Status</b></caption>
 </center>
	<table class="table1">
		<thead>
		<tr>
			<th>Type</th>
			<th>Code</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Days Requested</th>
			<th>Status</th>
		<!--<th>Select</th>-->
		</tr>
		</thead>
		<tbody>
		<tr>
<?php
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
	//echo" 	<td class=\"center\">";
   // echo"     <input type=\"checkbox\" name=\"startdate[]\" value=$leaveinfo[1]>";  
  //  echo"     </br></td>";
echo"  </tr>";
}
?>
</tbody>
	</table>
</br>

  <!-<  <input  type="submit" style="cursor:pointer" name="Remove_Request" value="Remove Request" >
<!-</form>
</div>

<form action = "approve_or_cancel_leave.php" method = "post">
<head>
	<link rel="stylesheet" href="../css/table.css">
	<style>

	@media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
	
		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr { 
			display: block; 
		}
		
		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr { 
			position: absolute;
			top: -9999px;
			left: -9999px;
		}
		
		tr { border: 1px solid #ccc; }
		
		td { 
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee; 
			position: relative;
			padding-left: 50%; 
		}
		
		td:before { 
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%; 
			padding-right: 10px; 
			white-space: nowrap;
		}
		
		/*
		Label the data
		*/
		.table2 td:nth-of-type(1):before { content: "Last Name"; }
		.table2 td:nth-of-type(2):before { content: "First Name"; }
		.table2 td:nth-of-type(3):before { content: "Type"; }
		.table2 td:nth-of-type(4):before { content: "Start Date"; }
		.table2 td:nth-of-type(5):before { content: "End Date"; }
		.table2 td:nth-of-type(6):before { content: "Days Requested"; }
		.table2 td:nth-of-type(7):before { content: "Status"; }
		.table2 td:nth-of-type(8):before { content: "Approved By"; }
		.table2 td:nth-of-type(9):before { content: "Select"; }
	}
	
	/* Smartphones (portrait and landscape) ----------- 
	@media only screen
	and (min-device-width : 450px)
	and (max-device-width : 480px) {
		body { 
			padding: 0; 
			margin: 0; 
			width: 320px; }
		}*/
	
	
	/* iPads (portrait and landscape) ----------- 
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		body { 
			width: 900px; 
		}
	}*/
	
	</style>
	</head>	
	<body>
	<div id="page-wrap">
<center>
<?php
if(strcmp($role,$Level_0)!=0)
{
?>
 <caption><b>Employee Table</b></caption>
 </center>
		<table class="table2">
		<thead>
		<tr>
		<th >Last Name</th> 
		<th >First Name</th> 
		<th >Type</th> 
		<th >Start Date</th> 
		<th >End Date</th> 
		<th >Days Requested</th> 
	  	<th >Status</th> 
		<th >Approved By</th> 
		<th >Select</th> 
		</tr>
		</thead>
		<tbody>
		<tr>
  
<?php
	if($department_id !=9){
   $request ="SELECT Startdate,Enddate,Status,Approved_by,Leave_id,employee_leave_tbl.Employee_id,Leave_id FROM employee_leave_tbl JOIN employee_department_tbl 
		ON employee_department_tbl.Employee_id=employee_leave_tbl.Employee_id WHERE Department_id='$department_id' ORDER BY `employee_leave_tbl`.`Startdate`  DESC";
		$requesting = mysql_query($request,$conn);
	}
	else{
		   $request ="SELECT Startdate,Enddate,Status,Approved_by,Leave_id,employee_leave_tbl.Employee_id,Leave_id FROM employee_leave_tbl JOIN employee_department_tbl 
		ON employee_department_tbl.Employee_id=employee_leave_tbl.Employee_id ORDER BY `employee_leave_tbl`.`Startdate`  DESC";
		$requesting = mysql_query($request,$conn);
	}
		
	while($row = mysql_fetch_array($requesting)){

		if(! $requesting ) {
			die('Could not connect: ' . mysql_error());
		}  
		$request1 ="SELECT `Role` FROM $roles_tbl WHERE Role_id=$row[5]";
		$requesting1 = mysql_query($request1,$conn);
		$roles = mysql_fetch_array($requesting1);
		$roles=$roles[0];
		if(! $row ) {
			die('Could not connect: ' . mysql_error());
		}  
		$Startdate		=$row[0];
		$Endate			=$row[1];
		$Status			=$row[2];
		$Approved_by	=$row[3];
		$Leave_id		=$row[4];
		$ids    		=$row[5];
		$leave_id		=$row[6];
		
		if(strcmp($Leave_id,"HL")==0){
			$days=0.5;
		}else{
		$days=numberofdayswithoutweekends($Startdate,$Endate);
		}
		//get leave type
		$leave ="SELECT `Leave_type` FROM $leaves_tbl WHERE Leave_id='$leave_id'"; 
		$leaving = mysql_query($leave,$conn);
		$getleave =mysql_fetch_array($leaving);
		
		// To remove the underscore
		$leave_type=$getleave[0];
		$leave_type = str_replace("_"," ", $leave_type);
		$name ="SELECT Lastname,Firstname FROM $employee_tbl WHERE Employee_id='$ids'";
		$naming=mysql_query($name,$conn);
		$getname= mysql_fetch_array($naming);
		if(! $getname ) {
			die('Could not connect: ' . mysql_error());
		}  
		$Lastname		=	$getname[0];
		$Firstname		=	$getname[1];
		if(strcmp($role,$Level_1)==0 && ((strcmp($roles,$Level_0)==0)||strcmp($roles,$Level_1)==0)){
		echo"		<td >$Lastname</td> 			";
		echo"		<td >$Firstname</td>			";
		echo"		<td >$leave_type</td>			";
		echo"		<td >$Startdate</td>			";
		echo" 		<td >$Endate</td> 				";
		echo"		<td >$days</td>					";
		echo" 	  	<td >$Status</td>				";
		echo" 	  	<td >$Approved_by</td>			";
		echo" 		<td class=\"center\">			";
		echo"     <input type=\"checkbox\" name=\"select[]\" value='$row[5]#$Startdate'>";  
		echo" 	   </br></td>							";
		echo" 		</tr>							";
		}
		else if(strcmp($role,$Level_2) ==0){
		echo"		<td >$Lastname</td> 			";
		echo"		<td >$Firstname</td>			";
		echo"		<td >$leave_type</td>			";
		echo"		<td >$Startdate</td>			";
		echo" 		<td >$Endate</td> 				";
		echo"		<td >$days</td>					";
		echo" 	  	<td >$Status</td>				";
		echo" 	  	<td >$Approved_by</td>			";
		echo" 		<td class=\"center\">			";
		echo"     <input type=\"checkbox\" name=\"select[]\" value='$row[5]#$Startdate'>";  
		echo" 	   </br></td>							";
		echo" 		</tr>							";
		}	
	}
?>

</tbody>
</table>

</br>
<input type="submit" style="cursor:pointer" name="Approve" value="Approve">
<input type="submit" style="cursor:pointer" name="Cancel" value="Cancel">
</form>

</div>
<?php
}
?>
</body>
</html>

