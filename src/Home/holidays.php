
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
<body >
	<center>
<h1>
</br>
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</h1>
</center>
<?php
createtoolbar();
$conn = connecttodatabase();
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];

?>
<head>
<link rel="stylesheet" href="../css/table.css">
<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
  <script>
  $(document).ready(function() {
    $("#datepicker").datepicker({
		dateFormat:'yy-mm-dd',
		numberOfMonths: 1,
		changeMonth: true,//this option for allowing user to select month
		changeYear: true //this option for allowing user to select from year range
		
});
   
  });
  </script>
</head>
	


<div style ="float:left;margin:10px;">
<form action="submit_holiday.php" method="POST">
  <label>Description: </label><input id="description" name="description" autocomplete="off"/></br></br>
 <label> Date: </label><input id="datepicker" name="datepicker" autocomplete="off"/></br></br>
  <input type="submit" style="cursor:pointer" name="holiday" value="Submit">
</form>
</div>
</br></br>
</br></br>
<?php
	
    $sql = "SELECT Description,Date FROM $holidays_tbl ORDER BY `Date`  DESC";
	$request = mysql_query($sql,$conn);

?>
<div id="page-wrap">
<!--<center>
 <caption><b>Holidays</b></caption>
 </center>-->
	<table class="table1">
		<thead>
		<tr>
			<th>Description</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>
		<tr>	
<?php
		while($holiday = mysql_fetch_array($request)){
	echo"		<td>$holiday[0]</td>	";
	$newDate = date("d-M-Y", strtotime($holiday[1]));
	echo"		<td>$newDate</td>	";
	echo"	</tr>";
		}
	?>
        </br></td>
  </tr>
</tbody>
	</table>
</body>
</html>
