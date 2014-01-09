<?php

class Form {
	private $elements = null;
	private $id = null;

	public function __construct(){
		$this->elements = array();

		$submitIndicator = new FormElementHidden('submitIndicator');
		$submitIndicator->setValue(false);
		$this->addElement($submitIndicator);
	}

	public function addElement($element){
		$this->elements[$element->getName()] = $element;
	}

	public function getElement($name){
		return $this->elements[$name];
	}

	public function getElements(){
		return $this->elements;
	}

	public function render(){
		$this->getElement('submitIndicator')->setValue(true);
		$tpl = Tpl::getInstance();
		$content = '';

		foreach($this->elements as $element){
			$content .= $element->render();
		}

		return $tpl->render('form/form', array(
									'content' 	=> $content,
									'method' 	=> 'POST',
									'id'		=> $this->getId() === null ? '' : 'id="'.$this->getId().'"'
									));
	}

	public function populate($values){
		foreach($values as $key => $value){
			$element = $this->getElement($key);
			if($element !== null){
				$element->setValue($value);
			}
		}
	}

	public function isSubmited(){

		return (bool)$this->getElement('submitIndicator')->getValue();
	}

	public function setSubmited($flag){
		$this->getElement('submitIndicator')->setValue($flag);
	}

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function __toString(){
		return $this->render();
	}
}

?>