<?php

class FormElementHidden extends FormElement {
	public function render(){
		return $this->renderTemplate('hidden', array());
	}

	protected function renderTemplate($name, $params = array())
	{
		$tpl = Tpl::getInstance();
		$params = array_merge($params, array('name' => $this->getName(), 'value' => $this->getValue()));
		return $element = $tpl->render('form/elements/'.$name, $params);
	}

}

?>