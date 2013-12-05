<?php

class PartialLending extends Partial {

	/**
	 * @var Lending
	 */
	private $lending;

	private $template;

	public function __construct($lending, $template = null){
		parent::__construct('lending');
		$this->lending = $lending;
		$this->template = $template == null ? 'lending' : $template;
	}

	public function render(){
		return $this->renderSubtemplate($this->template, array(
													'name' 			=> $this->lending->getMedium()->getName(),
													'description' 	=> $this->lending->getMedium()->getDescription(),
													'id'			=> $this->lending->getId(),
													'status'		=> $this->lending->getLongStatus()
													));
	}

	public static function wrap($lendings = array(), $template = null){
		$partials = array();
		foreach($lendings as $lending){
			$partials[] = new self($lending, $template);
		}
		return $partials;
	}

}

?>