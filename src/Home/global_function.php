<?php
require "global_variable.php";

//Calculate the number of days excluding weekends and holidays
function numberofdayswithoutweekends($start,$end ){
require "global_variable.php";
	$startdate = new Datetime (date($start));
	$enddate = new Datetime (date($end));
	$enddate->modify('+1 day');

	$interval = $enddate->diff($startdate);

	// total days
	$days = $interval->days;

	// create an iterateable period of date (P1D equates to 1 day)
	$period = new DatePeriod($startdate, new DateInterval('P1D'), $enddate);
	//get holidays
	$conn = connecttodatabase();
	  $sql = "SELECT Date FROM $holidays_tbl ORDER BY `Date`  DESC";
	$request = mysql_query($sql,$conn);
	$holidays_date = array();
	while($holiday = mysql_fetch_array($request)){
		$holidays_date[]=$holiday[0];
	}
	// best stored as array, so you can add more than one
	
	foreach($period as $dt) {
		$curr = $dt->format('D');

	//	 for the updated question
		if (in_array($dt->format('Y-m-d'), $holidays_date)) {
		   $days--;
		}

		// substract if Saturday or Sunday
		if ($curr == 'Sat' || $curr == 'Sun') {
			$days--;
		}
	}return $days;
}
//Check whether dates are valid
function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
//get Lastname from id
function getlastnamefromid($id){
	require "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);
	mysql_select_db($database);
	$request ="SELECT Lastname FROM $employee_tbl WHERE Employee_id = $id";
	$requesting = mysql_query($request,$conn);
	if(! $requesting ) {
			die('Could not connect: ' . mysql_error());
		}  
	$lastname = mysql_fetch_array($requesting);
	return $lastname[0];
}
function connecttodatabase(){
	require "global_variable.php";
	$conn = mysql_connect($dbhost, $dbuser);	
	mysql_select_db($database);
	return $conn;
}
?>