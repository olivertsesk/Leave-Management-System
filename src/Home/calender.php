
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
<body >
	<center>
<h1>
</br>
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</h1>
</center>
<?php
createtoolbar();
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];
$department_id  = $_SESSION["department_id"];
?>
<head>
<link rel="stylesheet" href="../css/table.css">
<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script type="text/javascript">

</script>
  <script>
  $(document).ready(function() {
    $("#startpicker").datepicker({
		minDate:0,
		dateFormat:'yy-mm-dd',
		numberOfMonths: 2,
		onSelect: function(selected) {
          $("#endpicker").datepicker("option","minDate", selected)
        }
});
     $("#endpicker").datepicker({
		 minDate:0,
		dateFormat:'yy-mm-dd',
		numberOfMonths: 2,
		onSelect: function(selected) {
          $("#startpicker").datepicker("option")
        }
	 });
  });
  </script>
</head>
	


<div style ="float:left;margin:10px;">
<form action="check_date.php" method="POST">
  <label>Start Date: </label><input id="startpicker" name="startdate" readonly="true"autocomplete="off"/></br></br>
 <label> End Date: </label><input id="endpicker" name="enddate" readonly="true" autocomplete="off"/></br></br>
 <label> Reason :</label> 
  <select id="reason" name="reason">
	  <option value="LL">Local Leave</option>
	  <option value="SL">Sick</option>
	  <option value="ML">Maternity Leave</option>
	  <option value="PL">Paternity Leave</option>
	  <option value="BW">Bad Weather</option>
	  <option value="OC">Office Closed</option>
	  <option value="OL">Overseas Leave</option>
	  <option value="WE">Wedding Event</option>
	  <option id="IsHalfDay" value="HL">Half Local</option>
	  <option value="CS">Customer Site</option>
	  <option value="TL">Training </option>
	  <!-- <option value="LA">Late </option> 
	  <option value="TC">Temporary Card</option>
	  <option value="overseas">Mission</option>-->
	  
	</select>
</br></br>
 <input type="submit" style="cursor:pointer" name="dates" value="Submit">
</form>
</div>

<?php

$conn = connecttodatabase();
   $fetch = "SELECT Amount,Leave_id,Leave_type FROM $leaves_tbl where Amount IS NOT NULL";
   $fetching = mysql_query($fetch,$conn);
   

   $sql = "SELECT * FROM $employee_leave_tbl WHERE employee_id='$id'";
   $result = mysql_query($sql,$conn);
   $row = mysql_fetch_array($result);
   		echo"<table class=\"table1\">";
		echo"<thead>";
		echo"<tr>";
		echo"<th>Code</th>";
		echo"<th >Type</th>";
		echo"   <th>Remaining</th> ";
		echo"   <th>Pending</th> ";
		echo"   <th>Approved</th> ";
		echo"</tr>";
		echo"</thead>";
		echo"<tbody>";

	
	//Initialisation
	$days_pending = 0;
	$days_approved = 0;
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
		if(strcmp($constant_amount[1],"LL")==0){
		   	$active_leave =	"SELECT Startdate,Enddate,Status,Leave_id FROM $employee_leave_tbl where Employee_id='$id' and Leave_id='$constant_amount[1]' OR Leave_id='HL'";
			
	   echo"<tr>";
	   echo"   <td>$code</td> ";
	   }else{
		   	$active_leave =	"SELECT Startdate,Enddate,Status,Leave_id FROM $employee_leave_tbl where Employee_id='$id' and Leave_id='$constant_amount[1]'";
		echo"<tr>";
		echo"   <td>$code</td> ";	  
	  }
	$fetch_active_leave = mysql_query($active_leave,$conn);
		echo"   <td>$type</td> ";
		while($row = mysql_fetch_array($fetch_active_leave)){
			
			$startdate = $row[0];
			$enddate = $row[1];
			$status = $row[2];
			$leave_id = $row[3];
		
			if(strcmp($status,"Approved") == 0 && strcmp($leave_id,"HL") == 0){
				$days_approved +=0.5 ;
			}
			else if(strcmp($status,"pending") == 0 && strcmp($leave_id,"HL") == 0){
				$days_pending += 0.5;
			}
			else if(strcmp($status,"pending") == 0){
				$days_pending += numberofdayswithoutweekends($startdate,$enddate);
			}
			else if(strcmp($status,"Approved") == 0){
				$days_approved += numberofdayswithoutweekends($startdate,$enddate);
			}
			
		}
		
		$remaining = $remaining - $days_pending - $days_approved;
		echo"   <td>$remaining</td> ";
		echo"   <td>$days_pending</td> ";
		echo"   <td>$days_approved</td> ";
		if(strcmp($code,"LL") == 0){
			$_SESSION["ll"] = $remaining;
		}
		else if(strcmp($code,"OL") == 0){
			$_SESSION["ol"] = $remaining;
		}
		else if(strcmp($code,"SL") == 0){
			$_SESSION["sl"] = $remaining;
		}
		$days_pending = 0;
		$days_approved=0;
   }
   		echo" </tr>";
		echo"</tbody>";
		echo"</table>";

?>

</div>
</body>
</html>