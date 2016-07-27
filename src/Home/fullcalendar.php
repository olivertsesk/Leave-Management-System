<?php
include "global_function.php";
include "global_variable.php";
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
<center>
</br>
<body style="background-color:#80d4ff;">
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</center>
<?php
createtoolbar();
?>
<head>
<link rel='stylesheet' href='../fullcalendar/fullcalendar.css' />
<script src='../fullcalendar/lib/jquery.min.js'></script>
<script src='../fullcalendar/lib/moment.min.js'></script>
<script src='../fullcalendar/fullcalendar.js'></script>

</head>

<head>
<link rel="stylesheet" type="text/css" href="css/toolbar.css" media="screen" />
</head>

<?php
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];
$mydepartment	 = $_SESSION["department_id"];

?>





<script>
$(document).ready(function() {
   

    $('#calendar').fullCalendar({
header: {
     left:'prevYear,nextYear',
     center: 'title',
<!--    right: 'month,agendaWeek,agendaDay'-->
  },


 <!--   editable: true,-->
   eventLimit: true, 
        // put your options and callbacks here
	events: [	
<?php						
$conn = connecttodatabase();
mysql_select_db($database);


//Ids in the same department
if(strcmp($role,$Level_0)==0){
	$fetch_id ="Select roles_tbl.Role_id FROM employee_department_tbl
	JOIN roles_tbl ON employee_department_tbl.Employee_id=roles_tbl.Role_id 
	WHERE $employee_department_tbl.Department_id='$mydepartment' AND roles_tbl.Role='$Level_0'";
}
else if(strcmp($role,$Level_1)==0){
	$fetch_id ="Select roles_tbl.Role_id FROM employee_department_tbl
	JOIN roles_tbl ON employee_department_tbl.Employee_id=roles_tbl.Role_id 
	WHERE $employee_department_tbl.Department_id='$mydepartment' AND roles_tbl.Role <> '$Level_2'";
}
else{
	$fetch_id ="Select roles_tbl.Role_id FROM employee_department_tbl
	JOIN roles_tbl ON employee_department_tbl.Employee_id=roles_tbl.Role_id ";
}

$fetching_ids = mysql_query($fetch_id,$conn);

while($fetching_ids_array = mysql_fetch_array($fetching_ids)){

	$sql = "SELECT Startdate,Enddate,Lastname,Firstname,Leave_id,Status FROM 
			$employee_tbl JOIN employee_leave_tbl ON 
			$employee_tbl.Employee_id = $employee_leave_tbl.Employee_id and 
			$employee_leave_tbl.Employee_id  = '$fetching_ids_array[0]'";
	$fetching = mysql_query($sql,$conn);

	while($row = mysql_fetch_array($fetching)){
		$Startdate = $row[0];
		$Enddate = $row[1];
		$Lastname = $row[2];
		$Firstname = $row[3];
		$Leave_id = $row[4];
		$Status = $row[5];
			if(strcmp($Status,"pending") == 0){
				 echo"       {								";
				 echo"           title  : '$Lastname',		";
				 echo"           start  : '$Startdate',		";
				 echo"           end    : '$Enddate',				";
				 echo"  	description: 'This is a cool event',	";
				  echo" 		color  : '#E3BB28'					";				
				 echo"       },								";
			 }
			else if(strcmp($Status,"Approved") == 0){
				 echo"       {								";
				 echo"           title  : '$Lastname',		";
				 echo"           start  : '$Startdate',		";
				 echo"           end    : '$Enddate',				";
				 echo"  	description: 'This is a cool event',	";
				 echo" 			 color  : '#2DC81D'					";
				 echo"       },								";
			}	
	}

}
?>
    ],									
		eventRender: function(event, element) {
            element.qtip({
                content: event.description + '<br />' + event.start,
                style: {
                    background: 'black',
                    color: '#FFFFFF'
                },
                position: {
                    corner: {
                        target: 'center',
                        tooltip: 'bottomMiddle'
                    }
                }
            });
        }
		 
<?php
		
echo"    });								";
echo"});									";
echo"</script>								";
?>

<center>
<div  style="display:inline-block;min-width: 550px;max-width:700px;
    width: 100%;"id='calendar'></div>
	</center>
</br></br>
</body>

</html>
