
<?php
session_start();
if (!isset($_SESSION['id']) )
{                     
    session_unset();
    session_destroy();
    header("Location: please_login.php");
    exit();
}	
	require "../global_variable.php";
	require "../global_function.php";
?>

<!DOCTYPE html>
<html>
	<head>

	</head>	
		<?php
createtoolbar();
?>
		<body style="background-color:#80d4ff;">
<center>
<h1>
<a href="Homepage.php">
	<img src="img/logo.png" alt="Logo" style="width:230px;height:70px;">	
	</a>
</h1>

<p>Username already taken.</p>
<a href="register.html">Try Again!</a>
</center>
</body>
</html>


