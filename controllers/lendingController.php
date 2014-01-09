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

		$this->setTitle(ucfirst($this->medium->getName()).' ausleihen - Sharity');

		if($session->getUser()->getId() === $this->medium->getUser()->getId() && $this->lending->getId() !== 0){

			if(isset($params['status'])){
				$this->lending->setStatus($params['status']);
				$this->lending->save();
			}

			$this->owner = true;
		}else{
			if($this->lending->getStatus() == null || $this->lending->getStatus() == Lending::STATUS_WRONGDATE){

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
						/* hier könnte man in einer Erweiterung noch prüfen ob das
						   Medium wärend dieser Zeitspanne schon ausgeliehen wird
						   und es gar nicht möglich ist es auszuleihen. */

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
			}else{
				// Status _> Datum nicht bearbeitbar

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

		$partialUser = new PartialUser($this->lending->getLender());
		$params['lender'] = $partialUser->render();

		$address = $this->lending->getLender()->getAddress();
		$params['address'] = $address == '' ? 'Bitte noch Addresse im Dashboard angeben. <a href="'.$ROOT_FOLDER.'/dashboard">Zum Dashboard</a>' : $address;

		if(!$this->owner){
			if($this->lending->getStatus() == null || $this->lending->getStatus() == Lending::STATUS_WRONGDATE){
				$form = $this->form->render();
			}else{
				$form = '<p>Ausgeliehen von ' . date_format(new DateTime($this->lending->getDatefrom()), 'd.m.y')
					.' bis ' .date_format(new DateTime($this->lending->getDateto()), 'd.m.y');
			}
			$params['content'] = $this->renderSubtemplate('start', array_merge(array('form' => $form), $params));
		}else{
			$params['content'] = $this->renderSubtemplate('approve', array_merge(array('status' => $this->lending->getLongStatus()), $params));
		}


		return $params;
	}

	private function getForm(){
		$form = new Form();

		$elementMedium = new FormElementHidden('medium');
		$elementMedium->setValue($this->medium->getId());
		$form->addElement($elementMedium);

		$elementDateFrom = new FormElementDate('datefrom');
		$elementDateFrom->setLabel('Ausleihdatum');
		$form->addElement($elementDateFrom);

		$elementDateTo = new FormElementDate('dateto');
		$elementDateTo->setLabel('Rückgabedatum');
		$form->addElement($elementDateTo);

		return $form;
	}


}

?>