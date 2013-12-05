<?php

class Lending extends DBModel{

	const STATUS_PENDING 	= 'pending';
	const STATUS_YES		= 'yes';
	const STATUS_NO			= 'no';
	const STATUS_WRONGDATE	= 'wrongdate';

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


	public static function getAll($options){
		$bind = array();
		$where = 'WHERE 1';
		$medium = isset($options['medium']) ? $options['medium'] : null;

		if($medium !== null){
			$where .= ' AND mediumId = :mediumId';
			$bind['mediumId'] = $medium->getId();
		}
	   	return self::findAll('SELECT * FROM lendings '.$where, $bind);
	}

	public static function getByLender($user){
		return self::findAll('SELECT id FROM lendings WHERE lenderId = :lenderid', array('lenderid' => $user->getId()));
	}

	public static function getByOwner($user){
		return self::findAll('SELECT l.id FROM lendings AS l INNER JOIN mediums AS m ON(l.mediumId = m.id) WHERE m.userId = :userid', array('userid' => $user->getId()));
	}


	/*
	   public function __toString(){
	   return $this->x;
	   }
	*/



	public function save(){
		parent::doSave();
	}



	public function setDatefrom($datefrom) { $this->datefrom = $datefrom; }
	public function getDatefrom() {
		return $this->datefrom;
	}


	public function setDateto($dateto) { $this->dateto = $dateto; }
	public function getDateto() {
		return $this->dateto;
	}

	public function setStatus($status) { $this->status = $status; }
	public function getStatus() { return $this->status; }

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

	function getLongStatus(){
		$status = $this->getStatus();
		$longStatus = '';
		switch($status){
			case self::STATUS_YES:
				$longStatus = 'Angenommen';
				break;
			case self::STATUS_NO:
				$longStatus = 'Abgelehnt';
				break;
			case self::STATUS_WRONGDATE:
				$longStatus = 'Bitte anderes Datum wählen';
				break;
			case self::STATUS_PENDING:
				$longStatus = 'Ausstehend';
				break;
		}
		return $longStatus;
	}

}
?>