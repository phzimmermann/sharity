<?php

class Lending extends DBModel{

	private $datefrom;
	private $dateto;
	private $lender;
	private $lenderId;
	private $medium;
	private $mediumId;

	public function __construct($id = 0){
		$this->_table = 'lendings';
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


	/*
	   public static function findByXAndY($x, $y){
	   return Comment::findAll('SELECT * FROM lendings WHERE x = :x AND y = :y;', array(':x' => $x, ':y' => $y));
	   }
	*/


	/*
	   public function __toString(){
	   return $this->x;
	   }
	*/



	public function save(){
		parent::doSave();
	}



	public function setDatefrom($datefrom) { $this->datefrom = $datefrom; }
	public function getDatefrom() { return $this->datefrom; }


	public function setDateto($dateto) { $this->dateto = $dateto; }
	public function getDateto() { return $this->dateto; }


	public function setLenderId($lenderId) { $this->lenderId = $lenderId; }
	public function getLenderId() { return $this->lenderId; }

	function setLender($lender) {
		$this->lender = $lender;
		$this->setLenderId($lender->getId());
	}

	function getLender() {
		if($this->lender === null){
			$this->lender = new Lender($this->getLenderId());
		}
		return $this->lender;
	}


	public function setMediumId($mediumId) { $this->mediumId = $mediumId; }
	public function getMediumId() { return $this->mediumId; }

	function setMedium($medium) {
		$this->medium = $medium;
		$this->setMediumId($medium->getId());
	}

	function getMedium() {
		if($this->medium === null){
			$this->medium = new Medium($this->getMediumId());
		}
		return $this->medium;
	}



}
?>