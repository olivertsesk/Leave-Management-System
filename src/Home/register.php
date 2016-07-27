<?php
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}	
	require "global_variable.php";
	require "global_function.php";
	
	$firstname	 = $_POST['firstname'];
	$lastname	 = $_POST['lastname'];
	$title	 	 = $_POST['title'];
	$employeeid	 = $_POST['employeeid'];
	$email		 = $_POST['email'];
	$role 		 = $_POST['role'];
	$department  = $_POST['department'];
   $boolean = 0;
   if(strcmp($firstname,"")==0 && strcmp($lastname,"")==0 && strcmp($employeeid,"")==0
   && strcmp($email,"")==0)
   {
	   header("Location: register_page.php");
	   return true;
   }
   //Connect to database
	$conn = connecttodatabase();
   
   mysql_select_db($database);
   $fetch = "SELECT Employee_id,Email FROM $employee_tbl";
   $fetching = mysql_query($fetch,$conn);
  
   while($row = mysql_fetch_array($fetching))
   { 
	   if(strcmp($row[0],$employeeid)==0 || strcmp($row[1],$email)==0)
	   {
		   $boolean = 1;
	   }
   }
		if($boolean==0)
		{  
			$sql = "INSERT INTO $employee_tbl (Employee_id, Firstname,Lastname,Email,Title)
			VALUES ('$employeeid','$firstname','$lastname','$email','$title')";
			$retval = mysql_query( $sql, $conn );
			
			$sql ="INSERT INTO $employee_department_tbl (Employee_id,Department_id) 
			VALUES ('$employeeid','$department')";
			$retval = mysql_query( $sql, $conn );
			
			$sql ="INSERT INTO $roles_tbl (Role_id,Role) 
			VALUES ('$employeeid','$role')";
			$retval = mysql_query( $sql, $conn );
			
		header("Location: overview.php");
		//	if(! $retval ) {
		//		die('Could not get data: ' . mysql_error());
		//	}
		//	else{
			//	header("Location: ../Login.php");
		//		return true;
		//	}
		
		}
		else{
			 header("Location: register_error.php");
			 return true;
		}

mysql_close($conn);
?>
