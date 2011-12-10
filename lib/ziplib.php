<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// This is a class which is responsible for zip manipulations
//
class ZipLib {
	private $config;
	private $path;

	// constructor
	public function __construct($config) {
    	if(empty($config)) {
    		mylog('Config object is empty', 'ZipLib', true);
    		return;
    	}
    	
    	$this->config = $config;
    	$this->path = $config->getConfig('UPLOAD_PATH');
    	
    	mylog('ZipLib class loaded.');
	}
	
	// Function to unzip file in the same location where zip is located
    // $fileFullName - server path to the zip archive
    // 
    // return - success
    //
	public function unzipFile($fileFullName) {
		if (!file_exists($fileFullName)) {
			mylog('Cannot find ' . $fileFullName, 'unzipFile', true);
			return false;
		}
		
		try{
			$path = $this->path;
			
			$zip = new ZipArchive;
	     	$res = $zip->open($fileFullName);
	     	if ($res === TRUE) {
	         	$zip->extractTo($path);
	         	$zip->close();
	         	mylog('Extracted files OK.');
	         	return true;
	     	} else {
	         	mylog('Failed to extract files.');
	         	return false;
	     	}
		} catch (Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'unzipFile', true);
			return false;
		}
	}
	
	// Function to zip files into an archive
    // $fullFileNames - array of the server paths to the files which will be archived
    // $zipFullName - full path to the archive which will be created
    // $overwrite - flag to indicate if we want to overwrite an existing archive
    // 
    // return - success
    //
	public function zipFiles($fullFileNames, $zipFullName, $overwrite = true) {			    
	    if (count($fullFileNames) === 0) {
	    	mylog('Trying to compress 0 files', 'zipFiles', true);
	    	return false;
	    }
	    
	    if (empty($zipFullName)) {
	    	mylog('No archive name was specified', 'zipFiles', true);
	    	return false;
	    }
	    
	    foreach($fullFileNames as $file) {
	      	if (!file_exists($file)) {
	      		mylog('Going to compress an non existing file: ' . $file, 'zipFiles', true);
	      		return false;
	      	}
	    }
	    
	    try {
		    $zip = new ZipArchive();
		    if($zip->open($zipFullName, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
		      	mylog('Failed to open an archive: ' . $zipFullName, 'zipFiles', true);
		      	return false;
		    }
	
		    foreach($fullFileNames as $file) {
		      	$zip->addFile($file,$file);
		    }

		    mylog('The zip archive contains ' . $zip->numFiles . ' files with a status of ' . $zip->status);
		    
		    $zip->close();
		    
		    return true;
	    } catch (Exception $e) {
	    	mylog('Exception caught: ' . $e->getMessage(), 'zipFiles', true);
			return false;
	    }
	    
	}
}
?>