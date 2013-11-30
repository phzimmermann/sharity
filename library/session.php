<?php

class Session {

	private $instance = null;
	private $user = null;

	private function __construct(){
		if(isset($_SESSION['userid'])){
			$this->setUser(new User($_SESSION['userid']));
		}
	}

	public function getInstance(){
		if($this->instance === null){
			$this->instance = new self();
		}
		return $this->instance;
	}

	public function isLoggedIn(){
		return $this->user !== null;
	}

	public function setUser($user){
		$this->user = $user;
		if($this->user === null){
			unset($_SESSION['userid']);
			return;
		}
		$_SESSION['userid'] = $this->user->getId();
	}

	public function getUser(){
		return $this->user;
	}

	public function logout(){
		$this->user = null;
		unset($_SESSION['userid']);
	}
}