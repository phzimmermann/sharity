<?php

class FormElementTextarea extends FormElement {
	public function render(){
		return $this->renderTemplate('textarea', array());
	}
}


?>