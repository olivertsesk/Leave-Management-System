<?php

function createtoolbar(){ 
	include "global_variable.php";
	?>
	
<head>
<link rel="stylesheet" type="text/css" href="../css/toolbar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>
	 // DOM ready
	 $(function() {
	   
     // Create the dropdown base
      $("<select />").appendTo("nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Menu"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });
	</script>

</head>
<nav> 
  	<ul> 
<?php
$email  		= $_SESSION["email"];
$id 			= $_SESSION["id"];
$role   		= $_SESSION["role"];
$department_id  = $_SESSION["department_id"];
$lastname		=$_SESSION["lastname"]; 			
$firstname		=$_SESSION["Firstname"] ;

if(!(strcmp($role,"$admin")==0))
{
	echo" <li><a href=\"Homepage.php\">Homepage</a></li> ";
}
?>
<?php
if(!strcmp($role,$admin)==0)
{
echo"<li><a href=\"calender.php\">Request Leave</a></li>";
}

if(!(strcmp($role,"$admin")==0))
{
  echo"<li><a href=\"fullcalendar.php\">Calendar</a></li>";
}



if(strcmp($role,$Level_1) === 0 || strcmp($role,$Level_2 ) == 0||strcmp($role,$admin ) == 0){
echo"<li><a href=\"overview.php\">Overview</a></li>";

}
if((strcmp($role,"$admin")==0))
{
  echo"<li><a href=\"register_page.php\">Add User</a></li>";
}
if((strcmp($role,"$admin")==0))
{
  echo"<li><a href=\"holidays.php\">Holidays</a></li>";
}

?>
<li ><a href="Login.php">Log out</a></li>



</ul>	
</nav>
<?php
}
?>