<?php

class IndexController extends Controller {

	private $labels = null;
	private $newestProducts = null;

	public function run($params = array()){
		$this->setTitle('Ausleihen, Verleihen, Dinge brauchen die einem nicht geh�ren...');
		$this->labels = Label::getAll();
		$this->newestProducts = Medium::getLatest(4); //(new PartialProduct(new Medium(1)), new PartialProduct(new Medium(2)), new PartialProduct(new Medium(3)), new PartialProduct(new Medium(4)));
		return;
	}

	public function render(){
		$params = array();

		$params['labels'] = '';
		foreach($this->labels as $label){
			$params['labels'] .= $this->renderPartialTemplate('label', array('label' => $label->getName()));
		}

		$params['newest'] = '';
		foreach($this->newestProducts as $product){
			$product = new PartialProduct($product);
			$params['newest'] .= $product->render();
		}


		return $params;
	}

}

?>