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

	/**
	 * @var Form
	 */
	private $form;

	private $owner = false;

	public function run($params = array()){
		$session = Session::getInstance();
		if(!$session->isLoggedIn()){
			$this->redirect($ROOT_FOLDER.'/door/type/in');
		}

		if(!isset($params['lending'])){
			$this->lending = new Lending();
			$this->medium 	= new Medium($params['medium']);
			$this->lending->setMedium($this->medium);
		}else{
			$this->lending 	= new Lending($params['lending']);
			$this->medium	= $this->lending->getMedium();
		}

		$this->setTitle(ucfirst($this->medium->getName()).' ausleihen - Sharely');

		if($session->getUser()->getId() === $this->medium->getUser()->getId() && $this->lending->getId() !== 0){

			if(isset($params['status'])){
				$this->lending->setStatus($params['status']);
				$this->lending->save();
			}

			$this->owner = true;
		}else{

			$this->form = $this->getForm();
			$this->form->populate($params);

			if(!$this->form->isSubmited()){
				$datefrom = new DateTime($this->lending->getDatefrom());
				$dateto = new DateTime($this->lending->getDateto());
				$this->form->getElement('datefrom')->setValue($datefrom->format('Y-m-d'));
				$this->form->getElement('dateto')->setValue($dateto->format('Y-m-d'));
			}else{

				if(true){
					// keine Fehler
					$this->lending->setDatefrom($params['datefrom']);
					$this->lending->setDateto($params['dateto']);

					$this->lending->setLender($session->getUser());
					$this->lending->setStatus(Lending::STATUS_PENDING);

					$this->lending->save();

					if(!isset($params['lending'])){
						$this->redirect($ROOT_FOLDER.'/lending/lending/'.$this->lending->getId());
					}

				}
			}
		}

		return;
	}

	public function render(){
		$params = array();
		$params['content'] = '';


		/*
		if($this->lending->getId() === 0){

		}else{

		}
		*/
		if(!$this->owner){
			$params['content'] = $this->renderSubtemplate('start', array('form' => $this->form->render()));
		}else{
			$params['content'] = $this->renderSubtemplate('approve', array('status' => $this->lending->getLongStatus()));
		}


		return $params;
	}

	private function getForm(){
		$form = new Form();

		$elementMedium = new FormElementHidden('medium');
		$elementMedium->setValue($this->medium->getId());
		$form->addElement($elementMedium);

		$elementDateFrom = new FormElementDate('datefrom');
		$form->addElement($elementDateFrom);

		$elementDateTo = new FormElementDate('dateto');
		$form->addElement($elementDateTo);

		return $form;
	}


}

?>