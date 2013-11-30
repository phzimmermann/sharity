<?php
	class PartialHeader extends Partial{
		private $user;
		/**
		 * @param Session
		 */
		private $session = null;

		public function __construct(){
			parent::__construct('header');
			$this->session = Session::getInstance();
			$this->user = $this->session->getUser();
		}

		public function render(){

			$params = array();
			$params['user'] = $this->session->isLoggedIn() ? $this->user->getName() : '';

			$loginWindow = $this->renderSubtemplate(
				$this->session->isLoggedIn() ? 'loggedIn' : 'loggedOut',
				array());

			return $this->renderSubtemplate('header', array(
										'loginWindow' => $loginWindow
										));
		}
	}
?>