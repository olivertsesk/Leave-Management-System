<?php
    session_start() ;  
    session_unset();
    session_destroy(); 
?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />	
	</head>	
	<body>
<center>
<h1>
	<img src="../img/logo.png" alt="Logo" style="width:230px;height:70px;">	
</h1>
</center>
<div style ="float:left;margin:10px;">
<form action="check_login.php" method="POST">

	<Label>Email: </Label> <input type="text" name="email"></br>
	</br>
	<Label>Password:</Label> <input type="password" name="password"></br>
</br>
	<input type="submit" name="submit" value="Login" align="right">
	</form>
	</div>
</br></br>

</body>
</html>

