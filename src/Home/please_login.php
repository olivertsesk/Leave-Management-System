
<?php
session_start();
                   
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
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

<p>Please Login.</p>
<a href="Login.php">Try Again!</a>
</center>
</body>
</html>

