<?php

	abstract class Partial {
		private $partialName = null;

		public function __construct($partialName){
			$this->partialName = $partialName;
		}

		public abstract function render();

		public function getPartialName(){
			return $this->partialName;
		}

		protected function renderSubtemplate($name, $params){
			$tpl = Tpl::getInstance();
			return $tpl->render('partials/'.$this->getPartialName().'/'.$name, $params);
		}

		public function __toString(){
			return $this->render();
		}
	}
?>