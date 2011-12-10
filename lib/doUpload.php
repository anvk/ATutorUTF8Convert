<?php 
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// Main php file which will trigger language recoding
//

// INCLUDES
require_once('logger.php');
require_once('config.php');
require_once('uploader.php');
require_once('ziplib.php');
require_once('filer.php');
require_once('encoder.php');
require_once('atutorEncoder.php');
	
// for log reading convenience
mylog();
mylog();
mylog();

// Place where initial setting will be created. They could be also loaded from the file or other source
$configs = array();
$configs['UPLOAD_PATH'] = '../upload/';			// path where we will store temporarily zip file for decompression and conversion
$configs['CONVERTED_PREFIX'] = 'utf8_';			// prefix which we will add to every converted and archived language pack
$configs['ARCHIVE_PATH'] = '../archive/';		// folder where we will store all converted language packs
$configs['LANG_INFO_FILE'] = 'language.xml';	// file where we will find character set encoding for the ATutor language packs
$configs['LANG_CHARSET_TAG'] = 'charset';		// <tag> we will look in a language file to find encoding
$configs['DEFAULT_CHARSET'] = 'utf-8';			// default encoding. We will encode every language pack into

// Our object initialization
$config = new Config($configs);
$uploader = new Uploader($config);
$ziplib = new ZipLib($config);
$filer = new Filer($config);
$encoder = new Encoder($config);

// Inversion of Control. Passing plugins into our working class
$atutorEncoder = new ATutorEncoder($config, $uploader, $ziplib, $filer, $encoder);


$num_files = count($_FILES['user_file']['name']);

// Loop through language packs converting them
for ($i=0; $i < $num_files; $i++) {
    $filePath = $_FILES['user_file']['tmp_name'][$i];
    $fileName = basename($_FILES['user_file']['name'][$i]);
    
    $ut8EncodedFile = $atutorEncoder->utf8_encode($filePath, $fileName);
}

exit();
?>