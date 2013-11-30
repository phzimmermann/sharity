<?php
	abstract class FormElement {
		protected $name = null;
		protected $value = null;
		protected $label = null;
		protected $required = false;

		public abstract function render();

		protected function renderTemplate($name, $params = array()){
			$tpl = Tpl::getInstance();
			$params = array_merge($params, array('name' => $this->getName(), 'value' => $this->getValue()));
			$element = $tpl->render('form/elements/'.$name, $params);
			return $tpl->render('form/element', array(
													'label' => $this->getLabel() === null ? '' : $this->getLabel(),
													'element' => $element
													));
		}

		public function __construct($name, $label = ''){
			$this->name = $name;
			$this->setLabel($label);
		}

		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name = $name;
		}

		public function getValue(){
			return $this->value;
		}
		public function setValue($value){
			$this->value = $value;
		}

		public function getLabel(){
			return $this->label;
		}
		public function setLabel($label){
			$this->label = $label;
		}

		public function getRequired(){
			return $this->required;
		}
		public function setRequired($required = true){
			$this->required = $required;
		}

	}
?>