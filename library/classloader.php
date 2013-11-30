<?php
function __autoload($classname){
	
	$folders = array('library', 'models', 'controllers', 'forms', 'library/partials', 'library/form');
	foreach($folders as $folder){
		
		$file = $folder."/".strtolower($classname).".php";
		
		if (file_exists($file)){
			include_once($file);
		}
	}
}

?>