<?php

class SearchController extends Controller {

	private $labels = null;
	private $products = null;
	private $ajax = false;
	private $renderonly = null;

	public function run($params = array()){
		$this->products = array();
		$this->labels = array();

		if(isset($params['renderonly'])){
			$this->renderonly = $params['renderonly'];
		}

		$this->setTitle('Suchen');


		$this->ajax = isset($params['ajax']) && $params['ajax'];
		$this->setRenderTemplate(!$this->ajax);

		$this->findProductsByLabel($params);
		$this->findProductsByName($params);

		$this->findLabelsByName($params);

		return;
	}

	public function render(){
		if($this->ajax){
			return $this->renderAjax();
		}

		$params = array();

		$params['products'] = '';
		foreach(PartialProduct::wrap($this->products) as $product){
			$params['products'] .= $product->render();
		}

		$params['searchpanel'] = $this->renderPartialTemplate('searchpanel', array());

		return $params;
	}

	private function renderAjax(){
		header('Content-Type: text/html; charset=utf-8');
		$params = array();
		$params['products'] = '';
		$params['labels'] = '';

		/*
		foreach($this->products as $product){
			$params['products'] .= $product->getName();
		}
		*/


		$list = new ListRenderer(PartialProduct::wrap($this->products));
		$params['products'] = $list->__toString();

		foreach($this->labels as $label){
			$params['labels'] .= $this->renderPartialTemplate('label', array('label' => $label->getName(), 'labelid' => $label->getId()));
		}

		if($this->renderonly !== null){
			return array('content' => $params[$this->renderonly]);
		}


		return array('content' => $this->renderSubtemplate('ajax-response', $params));
	}

	private function findProductsByLabel($params){
		if(!isset($params['label'])){
			return;
		}
		$labels = Label::findByName($params['label']);
		foreach($labels as $label){
			$this->setTitle('Artikel mit Label '.$label->getName());
			$products = Medium::findByLabel($label);
			$this->products = array_merge($this->products, $products);
		}

	}

	private function findProductsByName($params){
		if(!isset($params['text'])){
			return;
		}

		$text = $params['text'];

		$this->setTitle('Suchen nach '.$text);

		$products = Medium::findByText($text);
		$this->products = array_merge($this->products, $products);
	}

	private function findLabelsByName($params){
		if(!isset($params['text'])){
			return;
		}
		$this->labels = array_merge($this->labels, Label::findByName($params['text'], false));


	}

}

?>