<?php

class FormElementText extends FormElement {
	public function render(){
		return $this->renderTemplate('text', array());
	}
}

?>