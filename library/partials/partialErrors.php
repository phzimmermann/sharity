<?php
	class PartialErrors extends Partial {
		private $errors = null;
		
		public function __construct($errors){
			parent::__construct('errors');
			$this->errors = $errors;
		}
		
		public function render(){
			$items = '';
			foreach($this->errors as $error){
				$items .= $this->renderSubtemplate('errorItem', array('error' => $error));
			}
			return $this->renderSubtemplate('errors', array('items' => $items));
		}
	}
?>