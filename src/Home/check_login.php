<?php
session_start();
include "global_variable.php";
include "global_function.php";
include "logging.php";


$email = $_POST['email'] ;
$password = $_POST['password'];

   
   $conn = connecttodatabase();
  
   $sql = "SELECT Password,Employee_id FROM $employee_tbl WHERE Email='$email'";
   $result = mysql_query($sql,$conn);
   $row = mysql_fetch_array($result);
	//Invalid email
	if(!$row){
		header("Location: Login_Error.php");
		return true;
	}
	  $id = $row[1];
	//To change for active directory
    if(strcmp($password,"") == 0){
			
	//Get role
	$request = "SELECT Role FROM $roles_tbl WHERE Role_id = '$row[1]'";
	$requesting = mysql_query($request,$conn);
	$role = mysql_fetch_array($requesting);
	
	//Get department
	$request_department ="SELECT Department_id FROM $employee_department_tbl WHERE Employee_id =$row[1]";
	$requesting_department = mysql_query($request_department,$conn);
	$department_id = mysql_fetch_array($requesting_department);

	$request3 = "SELECT Lastname,Firstname FROM $employee_tbl WHERE Employee_id=$id";
	$requesting3 = mysql_query($request,$conn);
	$result3 = mysql_fetch_array($requesting);


		//This will be passed to each webpage
		$_SESSION["email"] 			= $email;
		$_SESSION["id"] 			= $row[1];
		$_SESSION["role"] 			= $role[0];
		$_SESSION["department_id"] 	= $department_id[0];
		$_SESSION["lastname"] 		= $result3[0];
		$_SESSION["Firstname"] 		= $result3[1];

		logging($row[1],"Login");
		if(strcmp($role[0],$admin)==0)
		{
			header("Location:overview.php");
		}else{
			header("Location:Homepage.php");
		}

	}else{
    header("Location: Login_Error.php");
	return true;
	}
    mysql_close($conn);
   
?>
