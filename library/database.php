<?php

class Database { 
	private static $db; 
 
	static public function getInstance() { 
		if(!self::$db) { 
			self::$db = new PDO( 
				'mysql:host='.Configuration::DB_HOST.';dbname='.Configuration::DB_DATABASE.';port='.Configuration::DB_PORT, 
				Configuration::DB_USER, 
				Configuration::DB_PASSWORD, 
				array( 
					PDO::ATTR_PERSISTENT => true, 
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				) 
			); 
		} 
		return self::$db; 
	} 
}

?>
