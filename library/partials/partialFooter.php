<?php
	class PartialFooter extends Partial{
		
		public function __construct(){
			parent::__construct('footer');
		}
		
		public function render(){
			return $this->renderSubtemplate('footer', array());
		}
	}
?>