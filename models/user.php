<?php

class User extends DBModel{

	private $name;
	private $password;
	private $email;
	private $info;
	private $address;

	public function __construct($id = 0){
		$this->_table = 'users';
		parent::__construct($id);
	}

	public static function findAll($q, $bind = null){
		$db = Database::getInstance();
		$stmt = $db->prepare($q);
		$stmt->execute($bind);
		$rows = $stmt->fetchAll();
		$result = array();
		foreach($rows as $row){
			$result[] = new self($row['id']);
		}
		return $result;
	}

	public static function findByEmail($email){
		$users = self::findAll('SELECT id FROM users WHERE `email` = :email;', array(':email' => $email));
		if(count($users) > 0){
			return $users[0];
		}
		return null;
	}

	public function __toString(){
		return $this->getName();
	}

	public function save(){
		parent::doSave();
	}

	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }

	public function setPassword($password) { $this->password = $password; }
	public function getPassword() { return $this->password; }

	public function setEmail($email) { $this->email = $email; }
	public function getEmail() { return $this->email; }

	public function setInfo($info) { $this->info = $info; }
	public function getInfo() { return $this->info; }

	public function setAddress($address){
		$this->address = $address;
	}
	public function getAddress(){
		return $this->address;
	}

	public function get_gravatar($s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $this->getEmail() ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}

}
?>