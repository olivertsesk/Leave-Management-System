<?php
require "global_variable.php";
require "global_function.php";
require "makemenu.php";
include "../mpdf/mpdf.php";
session_start();

if (!isset($_SESSION['id'])) 
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}
$role = $_SESSION["role"];
if(!((strcmp($role,$Level_1) == 0) ||(strcmp($role,$Level_2)) == 0||(strcmp($role,$admin)) == 0)){
	session_unset();
   session_destroy();
    header("Location: access_denied.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
</head>
		<body style="background-color:#80d4ff;">
<center>
<h1>
</br>
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</h1>
</center>
<head>
<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
<link rel="stylesheet" href="../css/layout.css">
<link rel="stylesheet" href="../css/table.css">
</head>
<?php
createtoolbar();
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$user_role   	= $_SESSION["role"];
$department_id  = $_SESSION["department_id"];
if(isset($_POST['department'])){
$filter_department = $_POST['department'];
}
?>

<script>
$(document).ready(function () {
    $('#selectall').click(function () {
        $('.selectedId').prop('checked', isChecked('selectall'));
    });
});
function isChecked(checkboxId) {
    var id = '#' + checkboxId;
    return $(id).is(":checked");
}
function resetSelectAll() {
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    if ($(".selectedId").length == $(".selectedId:checked").length) {
        $("#selectall").attr("checked", "checked");
    } else {
        $("#selectall").removeAttr("checked");
    }

    if ($(".selectedId:checked").length > 0) {
        $('#edit').attr("disabled", false);
    } else {
        $('#edit').attr("disabled", true);
    }
}
</script>
<div id="page-wrap">
<?php
	if(strcmp($user_role,$admin)==0){
		?>
<form action="overview.php" method="post">
<label> Department:</label>
 <select id="department" name="department">
	 <option value="1">ESS</option>
	 <option value="2">BSS</option>
	  <option value="3">NSS</option>
	  <option value="4">BMS</option>
	   <option value="5">Accounting</option>
	   <option value="6">BTL</option>
	  <option value="7">CDC</option>
	  <option value="8">SST</option>
<input type="submit" name="filter" value="filter" align="center"></br>
</form>
<form action = "../generatepdf/mpdf.php" method = "post">
<?php
}
		?>

<center>
</br>
 <caption><b>Employee Table</b></caption>
<table >
	<thead>
	<tr>
  <th >Last Name</th> 
  <th >First Name</th> 
  <th >Email</th>
  <th >Id</th>
   <th >Department</th> 
    <th >Role</th> 
	<?php
	if(strcmp($user_role,$admin)==0){
		
 echo"<th><input type=\"checkbox\" id=\"selectall\" /></th>";
	}
	?>
  </tr>
		</thead>
		<tbody>
		<tr>
  </tr>

<?php

$id = $_SESSION['id'];
	$conn = connecttodatabase();
	
    $sql = "SELECT Department_id FROM $employee_department_tbl where Employee_id ='$id'";
	$request = mysql_query($sql,$conn);
	$department = mysql_fetch_array($request);
	if(isset($filter_department)){
	//Same id as supervisor
	$department_id = $department[0];
	$sql = "SELECT Lastname,Firstname,Email,Department_id,employee_tbl.Employee_id FROM employee_tbl JOIN employee_department_tbl ON 
	employee_tbl.Employee_id=employee_department_tbl.Employee_id and employee_department_tbl.Department_id='$filter_department' ORDER BY Lastname ASC";
	$fetching = mysql_query($sql,$conn);
	}else{
	//Same id as supervisor
	$department_id = $department[0];
	$sql = "SELECT Lastname,Firstname,Email,Department_id,employee_tbl.Employee_id FROM employee_tbl JOIN employee_department_tbl ON 
	employee_tbl.Employee_id=employee_department_tbl.Employee_id ORDER BY Lastname ASC";
	$fetching = mysql_query($sql,$conn);
	}
	
	while($info = mysql_fetch_array($fetching)){
			$request ="SELECT `Department-Name` FROM $department_tbl WHERE Department_id=$info[3]";
			$requesting = mysql_query($request,$conn);
			$department = mysql_fetch_array($requesting);
			$lastname	= $info[0];
			$firstname	= $info[1];
			$email		= $info[2];
			$usersid    = $info[4];
			
			$department	= $department[0];
			$request1 ="SELECT `Role` FROM $roles_tbl WHERE Role_id = $usersid";
			$requesting1 = mysql_query($request1,$conn);
			$role = mysql_fetch_array($requesting1);
			$roles		= $role[0];
		if(strcmp($user_role,$admin)!=0 && strcmp($user_role,$Level_2)!=0){	
			
			if(strcmp($user_role,$Level_1)==0 && ((strcmp($roles,$Level_0)==0)||strcmp($roles,$Level_1)==0)){
			echo"		<td >$lastname</td> 			";
			echo"		<td >$firstname</td> 			";
			echo"		<td >$email</td>				";
			echo"		<td >$usersid</td>				";
			echo"		<td >$department</td> 			";
			echo"		<td >$roles</td> 				";
			echo" </tr>									";
			}
			else if(strcmp($user_role,$Level_2) ==0 || strcmp($user_role,$admin)==0){
			echo"		<td >$lastname</td> 			";
			echo"		<td >$firstname</td> 			";
			echo"		<td >$email</td>				";
			echo"		<td >$usersid</td>				";
			echo"		<td >$department</td> 			";
			echo"		<td >$roles</td> 				";
			echo"<td></td>";
			echo" </tr>";
			}
		}else if(strcmp($user_role,$admin) == 0||strcmp($user_role,$Level_2) == 0){
			if(strcmp($roles,$admin)!=0){
			echo"		<td >$lastname</td> 			";
			echo"		<td >$firstname</td> 			";
			echo"		<td >$email</td>				";
			echo"		<td >$usersid</td>				";
			echo"		<td >$department</td> 			";
			echo"		<td >$roles</td> 				";
		if(strcmp($user_role,$admin)==0){
			echo" 		<td class=\"center\">			";
			echo"     <input type=\"checkbox\" class=\"selectedId\" name=\"select[]\" value='$lastname#$firstname#$email#$department#$roles#$info[4]'>";  
			echo" 	   </td>							";
			echo" 		</tr>							";
			  }
			echo" </tr>";
			}
		}
	}
?>
</tbody>
	</table>
	</center>
	</br>
	<?php
	if(strcmp($user_role,$admin)==0){
 echo"<input type=\"submit\" style=\"cursor:pointer\"name=\"Individual\" value=\"Individual\">";
echo" <input type=\"submit\" style=\"cursor:pointer\" name=\"Group\" value=\"Group\">";
	}
	?>
  </div>
  </body>
  
</form>
</html>