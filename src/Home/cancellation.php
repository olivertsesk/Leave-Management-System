<?php
session_start();
if (!isset($_SESSION['username']) )
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

	</head>	
		<body style="background-color:#80d4ff;">
<center>
<h1>
	<b>Birger.</b>	
</h1>
<div style="float:left;margin:10px;">
<a href="Homepage.php">Homepage</a>
</div>
<div style="float:left;margin:10px;">
<a href="calender.php">Request day(s) off</a>
</div>
<div style="float:left;margin:10px;">
<a href="cancellation.php">Remove requested day</a>
</div>
</center>
</br></br>
Status

<head>   
<link href="calendar.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
include 'calendar.php';
 
$calendar = new Calendar();
 
echo $calendar->show();
?>
</body>
</html>

