<?php

class PartialProduct extends Partial {
	
	private $product;
	
	public function __construct($product){
		parent::__construct('product');
		$this->product = $product;
	}
	
	public function render(){
		return $this->renderSubtemplate('product', array(
													'name' 			=> $this->product->getName(), 
													'description' 	=> $this->product->getDescription(),
													'id'			=> $this->product->getId(),
													'niceName'		=> urlencode($this->product->getName())
													));
	}
	
	public static function wrap($products = array()){
		$partials = array();
		foreach($products as $product){
			$partials[] = new self($product);
		}
		return $partials;
	}

}

?>