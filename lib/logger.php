<?php
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// My special debug function for writing a log line into php log
//

// Function to write a log
// $message - message which will be written
// $where - part of the message which could be used to print the place where the log message has happened
// $error - bool. True - then the log message will be indicated as an error, debug message otherwise
// 
// return - nothing
//
function mylog($message='', $where='', $error=false) {
	// if no message is passed then just skip a line in the log
	if (empty($message)) {
		error_log('');
		return;
	}
	
	$error_part = '';
	$where_part = '';
	
	if ($error) {
		$error_part = 'ERROR - ';
	} else {
		$error_part = 'DEBUG - ';
	}
	
	if (!empty($where)) {
		$where_part = 'in ' . $where . ' ';
	}
	
	error_log($error_part . $where_part . $message);
}
?>