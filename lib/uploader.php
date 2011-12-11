<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// This is a class which is responsible for uploading manipulations
//
class Uploader {
	private $uploadPath;
	private $config;

	// constructor
	public function __construct($config) {
    	if(empty($config)) {
    		mylog('Config object is empty', 'Uploader', true);
    		return;
    	}
    	
    	$this->config = $config;
    	$this->uploadPath = $config->getConfig('UPLOAD_PATH');
    	
    	mylog('Upload class loaded.');
	}
	
	// Function to store a tmp uploaded file (which is removed) into a server location where it will be stored
    // $pathToFile - path to the tmp file which was uploaded through the input control
    // $fileName - name of the file which was uploaded
    // $newFullFileName - file name of the file on a server where it is gonna be stored
    // 
    // return - success
    //
	public function uploadFile($pathToFile, $fileName, $newFullFileName = '') {
		try{
			$uploadPath = $this->uploadPath;
		
    		if(empty($uploadPath)) {
    			mylog('Upload path is empty.', 'uploadFile', true);
    			return false;
    		}
    		
    		if (empty($pathToFile)) {
    			mylog('Path to the file is empty.', 'uploadFile', true);
    			return false;
    		}
    		
    		if (empty($fileName)) {
    			mylog('Filename is empty.', 'uploadFile', true);
    			return false;
    		}
    		
    		if (!empty($uploadPath) && !file_exists($uploadPath)) {
				mylog('WARNING cannot find an upload directory, so creating it: ' . $uploadPath);
				mkdir($uploadPath);
			}
    		
    		// If we do not care about the naming that copy file with the original name into the upload directory specified in settings
    		if (empty($newFullFileName)) {
    			$newFullFileName = $uploadPath . $fileName;
    			mylog('WARNING no upload path was set so defaulting it to ' . $uploadPath);
    		}
    		
    		if(move_uploaded_file($pathToFile, $newFullFileName)) {
				mylog("The file " . $fileName . " has been uploaded");
			} else {
 				mylog('Problem uploading file. My vars are: Path is ' . $pathToFile . ' FileName is ' . $fileName, 'uploadFile', true);
 				return false;
 			}
 			
 			return true;
		} catch (Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'uploadFile', true);
			return false;
		}
	}
}
 	
?>