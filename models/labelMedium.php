<?php

class LabelMedium extends DBModel{

	private $label;
	private $labelId;
	private $medium;
	private $mediumId;

	public function __construct($id = 0){
		$this->_table = 'label_mediums';
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



	public static function findByMedium($medium){
		return self::findAll('SELECT * FROM label_mediums WHERE mediumId = :medium;', array(':medium' => $medium->getId()));
	}


	/*
	public function __toString(){
		return $this->x;
	}
	*/



	public function save(){
		parent::doSave();
	}




	public function setLabelId($labelId) { $this->labelId = $labelId; }
	public function getLabelId() { return $this->labelId; }

	function setLabel($label) {
		$this->label = $label;
		$this->setLabelId($label->getId());
	}

	function getLabel() {
		if($this->label === null){
			$this->label = new Label($this->getLabelId());
		}
		return $this->label;
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