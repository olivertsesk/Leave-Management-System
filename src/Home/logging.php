<?php

function logging($user_id,$action){
	
	//path for logs
	$loggingfile = "../Logs/log.txt";
	
	$timestamp=date("Y-M-d")."<". date("h:i:s").">";

	$log = "[".$timestamp."]"."id ".$user_id." " .$action;
	
 $myfile = file_put_contents($loggingfile, $log.PHP_EOL , FILE_APPEND);
	
}

?>