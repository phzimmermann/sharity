<?php

class DoorController extends Controller {

	private $user = null;
	private $type = null;
	private $params = null;
	private $errors = null;

	public function run($params = array()){
		$this->type = $params['type'];
		$this->params = $params;
		$this->errors = array();

		// register
		if($this->type == 'register' && isset($params['email'])){
			$user = User::findByEmail($params['email']);
			if($user === null){
				$user = new User();
				$user->setEmail($params['email']);
				$user->setName($params['email']);
				$user->setPassword(md5('salt'.$params['password']));
				$user->setAddress($params['address']);
				$user->save();

				Session::getInstance()->setUser($user);

				$this->type= 'registerSuccess';
			}else{
				$this->errors[] = 'Diese E-Mail wird bereits verwendet.';
			}
		}

		// login
		if($this->type == 'in' && isset($params['email'])){
			$user = User::findByEmail($params['email']);
			if($user !== null){

				if(md5('salt'.$params['password']) == $user->getPassword()){
					Session::getInstance()->setUser($user);
					$this->type = 'inSuccess';
				}else{
					$this->errors[] = 'Passwort ist falsch.';
				}
			}else{
				$this->errors[] = 'Dieser Benutzer existiert nicht.';
			}
		}

		if($this->type == 'out'){
			Session::getInstance()->logout();
			$this->redirect('');
		}

		return;
	}

	public function render(){
		$params = array();
		$partialErrors = new PartialErrors($this->errors);

		switch($this->type){
			case 'in':
				$form = $this->createLoginForm();
				$registerLink = '<p>Noch kein Konto? Hier kannst Du dich registrieren. <a href="'.Configuration::ROOT_FOLDER.'/door/type/register">Registrieren</a></p>';
				$content = $this->renderSubtemplate('in', array(
															'form' => $form->render().$registerLink,
															'errors' => $partialErrors->render(),
															));
				$this->setTitle('Anmelden.');
				break;

			case 'out':

				break;
			case 'register':
				$this->setTitle('Registriere Dich bitte.');
				$form = $this->createLoginForm();
				$this->addRegisterElements($form);
				$content = $this->renderSubtemplate('in', array(
															'form' => $form->render(),
															'errors' => $partialErrors->render()
															));
				break;
			case 'inSuccess':
				$content = $this->renderSubtemplate('inSuccess', array());
				break;
			case 'registerSuccess':
				$content = $this->renderSubtemplate('registerSuccess', array());
				break;
		}

		$params['content'] = $content;
		return $params;
	}

	private function createLoginForm(){
		$form = new Form();
		$email = new FormElementText('email', 'E-Mail Adresse');
		$form->addElement($email);

		$password = new FormElementPassword('password', 'Passwort');
		$form->addElement($password);

		$form->populate($this->params);

		return $form;
	}

	private function addRegisterElements(Form &$form){

		$addressElement = new FormElementTextarea('address');
		$addressElement->setLabel('Adresse');

		$form->addElement($addressElement);

		return $form;
	}

}

?>