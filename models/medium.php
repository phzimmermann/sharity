<?php

class Medium extends DBModel{

	private $name;
	private $description;
	private $user;
	private $userId;

	public function __construct($id = 0){
		$this->_table = 'mediums';
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



	public static function findByLabel($label){
		return self::findAll('SELECT m.id FROM mediums AS m INNER JOIN label_mediums as lm ON(lm.mediumId = m.id) INNER JOIN labels as l ON(lm.labelId = l.id) WHERE l.id = :labelId;', array(':labelId' => $label->getId()));
	}

	public static function findByText($text){
		return self::findAll('SELECT m.id FROM mediums AS m WHERE m.name LIKE :text OR m.description LIKE :text2;', array(':text' => '%'.$text.'%', ':text2' => '%'.$text.'%'));
	}



	/*
	public function __toString(){
		return $this->x;
	}
	*/



	public function save(){
		parent::doSave();
	}



	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }


	public function setDescription($description) { $this->description = $description; }
	public function getDescription() { return $this->description; }


	public function setUserId($userId) { $this->userId = $userId; }
	public function getUserId() { return $this->userId; }

	function setUser($user) {
		$this->user = $user;
		$this->setUserId($user->getId());
	}

	function getUser() {
		if($this->user === null){
			$this->user = new User($this->getUserId());
		}
		return $this->user;
	}

	public function getImage(){
		$url = 'https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.urlencode($this->getName());
		$data = file_get_contents($url);
		$json = json_decode($data);
		$responseData = $json->responseData;
		if($responseData->results != null){
			$result = $responseData->results[1]->url;
			return $result;
		}

	}



}
?>