<?php
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// My special functions which do not fit any other class or category
//
// Function to write a log
// $successFiles - array of file names which were converted successfully
// $failedFiles - array of file names which failed to convert
// 
// return - String result for post back
//
function buildReply($successFiles = null, $failedFiles = null) {
	if (!empty($successFiles) && !is_array($successFiles)) {
		mylog('SuccessFiles is not an array', 'buildReply', true);
		returnErrorPostback();
	}
	
	if (!empty($failedFiles) && !is_array($failedFiles)) {
		mylog('FailedFiles is not an array', 'buildReply', true);
		returnErrorPostback();
	}
	
	$numConverted = count($successFiles);
	$failed = count($failedFiles);
	
	if ($numConverted !== 1) {
		$converted_filesStr = 'files';
	} else {
		$converted_filesStr = 'file';
	}
	
	if ($failed !== 1) {
		$failed_filesStr = 'files';
	} else {
		$failed_filesStr = 'file';
	}
		
	echo('Converted : ' . $numConverted . ' ' . $converted_filesStr . '. Failed to convert: ' . $failed . ' ' . $failed_filesStr . '.<br />');
	
	$success_string = '';
	foreach($successFiles as $file) {
		$success_string = $success_string . '<li><strong>' . $file . '</strong> - converted</li>';
	}
	
	$success_string = '<ul>' . $success_string . '</ul>';
	
	echo($success_string);
	
	$failed_string = '';
	foreach($failedFiles as $file) {
		$failed_string = $failed_string . '<li><strong>' . $file . '</strong> - failed to convert</li>';
	}
	
	$failed_string = '<ul>' . $failed_string . '</ul>';
	
	echo($failed_string);
}

function returnErrorPostback() {
	mylog('Something went wrong. Cannot return data.');
	return 'Error during Postback. Please check the logs or contact administrator.';
}
?>