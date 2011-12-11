<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// This is a class which is responsible for language recoding
//
class ATutorEncoder {
	private $config;
	private $uploader;
	private $ziplib;
	private $filer;
	private $encoder;

	// constructor. Using Inversion of Control to load plugins:
	public function __construct($config, $uploader, $ziplib, $filer, $encoder) {
    	
    	if (empty($config)) {
    		mylog('Config object is empty', 'ATutorEncoder', true);
    		return;
    	}
    	
    	if (empty($uploader)) {
    		mylog('Uploader object is empty', 'ATutorEncoder', true);
    		return;
    	}
    	
    	if (empty($ziplib)) {
    		mylog('Ziplib object is empty', 'ATutorEncoder', true);
    		return;
    	}
    	
    	if (empty($filer)) {
    		mylog('Filer object is empty', 'ATutorEncoder', true);
    		return;
    	}
    	
    	if (empty($encoder)) {
    		mylog('Encoder object is empty', 'ATutorEncoder', true);
    		return;
    	}
    	
    	$this->config = $config;
    	$this->uploader = $uploader;
    	$this->ziplib = $ziplib;
    	$this->filer = $filer;
    	$this->encoder = $encoder;
    	
    	$archivePath = $this->config->getConfig('ARCHIVE_PATH');
    	$uploadPath = $this->config->getConfig('UPLOAD_PATH');
    	
    	// Create directories on the server if they are not created yet
    	if (!empty($uploadPath) && !file_exists($uploadPath)) {
			mylog('WARNING cannot find an upload directory, so creating it: ' . $uploadPath);
			mkdir($uploadPath);
		}
		
		if (!empty($archivePath) && !file_exists($archivePath)) {
			mylog('WARNING cannot find an archive directory, so creating it: ' . $archivePath);
			mkdir($archivePath);
		}
    	
    	mylog('LangRecode class loaded.');
	}
	
	// Function which will take an input file, move to upload folde, unpack, convert and store in archive folder
    // $filePath - path to the tmp file which was uploaded through the input control
    // $fileName - name of the file which was uploaded
    // 
    // return - If everything worked then return link to the new recoded file. Null otherwsie
    //
	public function utf8_encode($filePath, $fileName) {
		try {

			// Step 1. Find the uploaded path where we will have our uploaded language pack
			$uploadPath = $this->config->getConfig('UPLOAD_PATH');
			
			// Step 2. Generate a full server path where we going to move our uploaded file
			$uploadedFileName = $uploadPath . $fileName;
			
			// Step 3. Upload and move the file
			if(!$this->uploader->uploadFile($filePath, $fileName)) {
				return null;
			}
			
			// Step 4. Unzip the archive
			if(!$this->ziplib->unzipFile($uploadedFileName)) {
				$this->filer->removeFile($uploadedFileName);
				return null;
			}
			
			// Step 5. Remove archive
			if(!$this->filer->removeFile($uploadedFileName)) {
				return null;
			}
			
			// Step 6. List all the unzipped files
			if(!$files = $this->filer->listFiles($uploadPath)) {
				return null;
			}
			
			// Step 7. Find charset encoding in the language pack
			$charset = $this->getEncodingFromATutorLangPack();
			
			// Step 8. Convert every single file we have
			foreach($files as &$f) {
				$this->encoder->utf8_encodeFile($f, $charset);
			}
			
			// Step 9. Get the new file path where the converted file will reside in the archive
			$prefix = $this->config->getConfig('CONVERTED_PREFIX');
			$archivePath = $this->config->getConfig('ARCHIVE_PATH');
			$convertedFile = $archivePath . $prefix . $fileName;
			
			// Step 10. Zip all converted files in a new archive
			$this->ziplib->zipFiles($files, $convertedFile);
			
			// Step 11. Remove all converted files except of new archive
			$this->filer->removeFiles($files);
			
			return $convertedFile;
		} catch (Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'utf8_encode', true);
			return null;
		}
	}
	
	// Function to find charset encoding from the language pack
    // 
    // return - String which represents file encoding
    //
	public function getEncodingFromATutorLangPack() {
		$charset = '';
		
		$lang_file = $this->config->getConfig('LANG_INFO_FILE');
		$uploadPath = $this->config->getConfig('UPLOAD_PATH');
		
		$file = $uploadPath . $lang_file;
		
		if(!file_exists($file)) {
			mylog('File ' . $file . ' does not exist', 'getEncodingFromATutorLangPack', true);
			return null;
		}
		
		try {
			// read the language file
			$content = file_get_contents($file);
			
			// find the tag which is responsible for charset
			$tag = $this->config->getConfig('LANG_CHARSET_TAG');
			$charset = $this->find_tag_content($content, $tag);
			mylog($charset);
			
			return $charset;
		} catch(Exception $e) {
			mylog('Exception caught: ' . $e->getMessage(), 'getEncodingFromATutorLangPack', true);
			return null;
		}
	}
		
	// Function to find a string between 2 other strings
	// $s - Original string
	// $str1 - BEFORE the string we are looking for
	// $str2 - AFTER the string we are looking for
	// $ignore_case - True if we care about the character case
    // 
    // return - a string which should reside between two other strings specified in the parameters
    //
	function find_between($s, $str1, $str2, $ignore_case = false) {
	    $func = $ignore_case ? stripos : strpos;
	    $start = $func($s, $str1);
	    if ($start === false) {
			return '';
	    }
	
	    $start += strlen($str1);
	    $end = $func($s, $str2, $start);
	    if ($end === false) {
			return '';
	    }
	
	    return substr($s, $start, $end - $start);
	}

	// Function to find a string between a specific XML tag
	// $s - Original string
	// $tag - string <tag> which we are looking for in a string
    // 
    // return - string inside the tag
    //
	function find_tag_content($s, $tag) {
	    return $this->find_between($s, "<$tag>", "</$tag>", true);
	}
}
?>