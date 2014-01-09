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

		$this->setTitle(
			$this->edit
			? 'Neues Produkt anlegen'
			: $this->product->getName());


		if($this->edit){

			$this->form = $this->getEditForm();

			$this->form->populate(array(
								'title' => $this->product->getName(),
								'description' => $this->product->getDescription(),
								'price'			=> $this->product->getPrice()
							));

			if(isset($params['do']) && $params['do'] == 'delete'){
				$this->product->delete();
				$this->redirect('dashboard');
			}

			$this->form->setSubmited($params['submitIndicator']);

			if($this->form->isSubmited()){

				$this->form->populate($params);
				$this->product->setUser($session->getUser());
				$this->product->setName($params['title']);
				$this->product->setDescription($params['description']);
				$this->product->setPrice($params['price']);
				$this->product->save();

				// Save Labels

				// - Delete all Labels
				$labels = LabelMedium::findByMedium($this->product);
				foreach($labels as $label){
					$label->delete();
				}
				// - Add labels again
				foreach($params['labels'] as $labelId){
					$lm = new LabelMedium();
					$label = new Label($labelId);
					$lm->setLabel($label);
					$lm->setMedium($this->product);
					$lm->save();
				}

				$this->redirect('product/id/'.$this->product->getId());
			}
		}


		$this->labels = Label::findByProduct($this->product);

		return;
	}

	public function render(){
		$params = array();

		$partialUser = new PartialUser($this->product->getUser());


		$params['name'] 		= $this->product->getName();
		$params['description'] 	= $this->product->getDescription();
		$params['id']			= $this->product->getId();
		$params['labels'] 		= '';
		$params['imgurl'] 		= $this->product->getImage();
		$params['editlink'] 	= !$this->edit && $this->isOwner
									? $this->renderSubtemplate('editlink', array('id' => $this->product->getId()))
									: '';
		$params['user'] 		= $partialUser->render();

		if(count($this->labels) > 0){
			foreach($this->labels as $label){
				if($this->edit){
					$params['labels'] .= $this->renderSubtemplate('labeledit', array('label' => $label, 'labelid' => $label->getId()));
				}else{
					$params['labels'] .= $this->renderPartialTemplate('label', array('label' => $label, 'labelid' => $label->getId()));
				}
			}
		}


		if($this->edit){
			$this->setView('product/edit');
			$this->form->setSubmited(true);
			$params['form'] = '';
			foreach($this->form->getElements() as $element){
				$params['form'] .= $element->render();
			}
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

		$elPrice = new FormElementText('price', 'Preis');
		$form->addElement($elPrice);

		return $form;
	}

}

?>