<?php

class ProductController extends Controller {

	private $labels = null;
	private $product = null;

	private $edit = false;

	private $isOwner = false;

	/**
	 * @param Form
	 */
	private $form;

	public function run($params = array()){
		$this->product = new Medium($params['id']);
		$session = Session::getInstance();
		$user = $session->getUser();


		$this->edit = $params['id'] == 0 || $params['edit'];
		if($session->isLoggedIn()){
			$this->isOwner = $user->getId() == $this->product->getUser()->getId();
		}

		if($this->edit == true && ($user == null || ($params['id'] != 0 && !$this->isOwner) )){
			header('location:'.Configuration::ROOT_FOLDER.'/door/type/in');
			return;
		}




		$this->setTitle($this->product->getName());

		$this->labels = Label::findByProduct($this->product);

		if($this->edit){

			$this->form = $this->getEditForm();

			$this->form->populate(array(
								'title' => $this->product->getName(),
								'description' => $this->product->getDescription(),
							));

			$this->form->setSubmited($params['submitIndicator']);

			if($this->form->isSubmited()){

				$this->form->populate($params);
				$this->product->setUser($session->getUser());
				$this->product->setName($params['title']);
				$this->product->setDescription($params['description']);
				$this->product->save();
				$this->redirect('product/id/'.$this->product->getId());
			}
		}

		return;
	}

	public function render(){
		$params = array();


		$params['name'] = $this->product->getName();
		$params['description'] = $this->product->getDescription();
		$params['labels'] = '';
		$params['imgurl'] = $this->product->getImage();
		$params['editlink'] = !$this->edit && $this->isOwner
									? $this->renderSubtemplate('editlink', array('id' => $this->product->getId()))
									: '';

		if(count($this->labels) > 0){
			foreach($this->labels as $label){
				$params['labels'] .= $this->renderPartialTemplate('label', array('label' => $label));
			}
		}


		if($this->edit){
			$this->setView('product/edit');
			$params['form'] = $this->form->render();
		}

		return $params;
	}

	/**
	 * @return Form
	 *
	 */
	private function getEditForm(){
		$form = new Form();

		$elTitle = new FormElementText('title', 'Titel');
		$form->addElement($elTitle);

		$elDescription = new FormElementTextarea('description', 'Beschreibung');
		$form->addElement($elDescription);

		return $form;
	}

}

?>