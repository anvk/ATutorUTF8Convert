<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
// 
// This is a class which is responsible for file manipulations on the server
//
class Filer {
	private $config;
	private $path;
	
	// constructor
	public function __construct($config) {
    	if(empty($config)) {
    		mylog('Config object is empty', 'Filer', true);
    		return;
    	}
    	
    	$this->config = $config;
    	$this->path = $config->getConfig('UPLOAD_PATH');
    	
    	mylog('Filer class loaded.');
	}
	
	// Function to remove a file
    // $fullFileName - a server path to the file including file's name
    // 
    // return - success
    //
	public function removeFile($fullFileName) {
		try{
			unlink($fullFileName);
			mylog('Removed ' . $fullFileName);
			return true;
		} catch (Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'remove', true);
			return false;
		}
	}
	
	// Function to remove files
    // $fullFileNames - an array of server paths to the files including files' names
    // 
    // return - success
    //
	public function removeFiles($fullFileNames) {
		if(empty($fullFileNames)) {
			mylog('WARNING array of files to be removed is empty.');
			return false;
		}
		
		if(!is_array($fullFileNames)) {
			mylog('File names should be an array.', 'removeFiles', true);
			return;
		}
		
		foreach($fullFileNames as &$fullFileName) {
			$this->removeFile($fullFileName);
		}
		return true;
	}
	
	// Function to get all full paths of the files listed in the specified location on the server
    // $path - path to the directory on the server
    // 
    // return - array of full file paths
    //
	public function listFiles($path) {
		try {
			$fileList = array();
			
			if ($handle = opendir($path)) {
			    while (false !== ($entry = readdir($handle))) {
					if ($entry === "." || $entry === "..") {
						continue;
					}
					array_push($fileList, $path . $entry);
			        mylog('Found file: ' . $entry);
			    }
			
			    closedir($handle);
			}
			
			return $fileList;
		} catch(Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'listFiles', true);
			return null;
		}
	}
}
?>