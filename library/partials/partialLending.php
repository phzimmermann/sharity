<?php

class PartialLending extends Partial {

	/**
	 * @var Lending
	 */
	private $lending;

	public function __construct($lending){
		parent::__construct('lending');
		$this->lending = $lending;
	}

	public function render(){
		return $this->renderSubtemplate('lending', array(
													'name' 			=> $this->lending->getMedium()->getName(),
													'description' 	=> $this->lending->getMedium()->getDescription(),
													'id'			=> $this->lending->getId()
													));
	}

	public static function wrap($lendings = array()){
		$partials = array();
		foreach($lendings as $lending){
			$partials[] = new self($lending);
		}
		return $partials;
	}

}

?>