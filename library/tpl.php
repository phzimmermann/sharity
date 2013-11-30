<?php

    class Tpl {

    	static private $instance = null;

    	private $user;

    	static public function getInstance(){
    		if (null === self::$instance) {
    			self::$instance = new self;
    		}
    		return self::$instance;
    	}

        var $templates = array();
        var $templatefolder;

        function tpl() {
            $this->templatefolder = 'templates';
        }

        function get($templatename, $templatepath = "") {
			if($templatepath == ""){
				$templatepath = $this->templatefolder;
			}
            if (!isset($this->templates[$templatename])) {
                if (file_exists($templatepath."/$templatename.tpl"))
                    $this->templates[$templatename] = str_replace("\"", "\\\"", implode("", file($templatepath."/$templatename.tpl")));
                else
                    return "Template nicht gefunden: ".$templatepath."/$templatename.tpl";
            }
            return $this->templates[$templatename];
        }

        function output($template) {
            print($template);
        }

        public static function show($values = array()){
        	if(count($values) > 0){
        		foreach ($values as $key => $value){
        			$key = strtoupper($key);
        			$$key = $value;
        		}
        	}
			$ROOT_FOLDER = Configuration::ROOT_FOLDER;
        	eval("\Tpl::getInstance()->output(\"".Tpl::getInstance()->get("site")."\");");
        }

        public static function render($template, $values = array()){
        	if(count($values) > 0){
        		foreach ($values as $key => $value){
	        		$key = strtoupper($key);
	        		$$key = $value;
	        	}
        	}
			$ROOT_FOLDER = Configuration::ROOT_FOLDER;
        	eval ("\$returnval = \"".Tpl::getInstance()->get($template)."\";");
        	return $returnval;
        }
    }


?>