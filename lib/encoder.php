<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// This is a class which is responsible for encoding strings
//

// Imports
require_once('ConvertCharset.class.full.php');

class Encoder {
	private $config;

	// constructor
	public function __construct($config) {
    	if(empty($config)) {
    		mylog('Config object is empty', 'Uploader', true);
    		return;
    	}
    	
    	$this->config = $config;
    	
    	mylog('Upload class loaded.');
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////
	///
	/// THIS IS THE PLACE WHERE YOU CAN USE ANY OTHER LIBRARY IN ORDER TO ENCODE A FILE
	/// IN THIS CASE I'M USING ConvertCharset.class.php from 
	/// http://www.phpclasses.org/package/1360-PHP-Conversion-between-many-character-set-encodings.html
	///
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Function to recode the file to the specified default encoding. In my case it is UTF-8
	// $file - File name on a server which will be converted
	// $encoding - CharSet encoding of the file
    // 
    // return - success
    //
	public function utf8_encodeFile($file, $encoding) {
		if(!file_exists($file)) {
			mylog('File ' . $file . ' does not exist', 'utf8_encodeFile', true);
			return false;
		}
		
		try {
			// get file content
			$content = file_get_contents($file);
			$default_encoding = $this->config->getConfig('DEFAULT_CHARSET');
			
			// If encoding is already a default one then we do not have anything to do here
			if (strcmp($encoding, $default_encoding) === 0) {
				mylog('WARNING file encoding is already set to the default ' . $default_encoding . ' encoding. Do not do anything');
				return true;
			}
			
			// If no encoding was passed then we do not do anything to the file
			if(empty($encoding)) {
				mylog('No encoding was passed! Keep file as it is.', 'utf8_encodeFile', true);
				return false;
			} else {
				$conversion = new ConvertCharset($encoding,$default_encoding);
				$new_content = $conversion->Convert($content);
			}
			
			mylog($new_content);
			
			// write new data into the file
			$handle = fopen($file, 'w');
			fwrite($handle, $new_content); 
			fclose($handle);
			
			return true;
		} catch(Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'utf8_encodeFile', true);
			return false;
		}
	}
}
?>