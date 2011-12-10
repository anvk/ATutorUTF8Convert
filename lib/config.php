<?php
// Alexey Novak <alexey.novak.mail@gmail.com>
//
// This is a class which is responsible for holding passed configuration settings.
//
class Config {
	private $configs;   
 		
 	// constructor 
    public function __construct($configs) {
		if(!empty($configs) && !is_array($configs)) {
			mylog('Config settings should be an array.', 'Config', true);
			return;
		}
		
		$this->configs = $configs;
        mylog('Config class loaded.');
    }
    	
    
    // Function to return a value from the config settings
    // $key - key to the value in a config setting array
    // 
    // return - variable from the config setting array
    //
    public function getConfig($key) {
    	$configs = $this->configs;
    	if (!array_key_exists($key, $configs)) {
    		mylog('Key ' . $key . ' does not exist in configuration.', 'getConfig', true);
			return null;
		}

		return $configs[$key];
    }
    
    //
    // Function to return an array of configuration settings
    //
    // return - array of config settings
    //
    public function getAllConfig() {
    	return $this->configs;
    }
}
?>