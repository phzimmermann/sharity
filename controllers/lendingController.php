<?php

class LendingController extends Controller{

	/**
	 * @var Medium
	 */
	private $medium;

	/**
	 * @var Lending
	 */
	private $lending;

	public function run($params = array()){
		$session = Session::getInstance();
		if(!$session->isLoggedIn()){
			$this->redirect($ROOT_FOLDER.'/door/type/in');
		}

		if(isset($params['medium'])){
			$this->medium 	= new Medium($params['medium']);
		}else{
			$this->lending 	= new Lending($params['lending']);
			$this->medium	= $this->lending->getMedium();
		}

		$this->setTitle(ucfirst($this->medium->getName()).' ausleihen - Sharely');
		return;
	}

	public function render(){
		$params = array();



		return $params;
	}
}

?>