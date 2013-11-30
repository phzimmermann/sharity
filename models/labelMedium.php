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
	
	
	/*
	public static function findByXAndY($x, $y){
		return Comment::findAll('SELECT * FROM labelMediums WHERE x = :x AND y = :y;', array(':x' => $x, ':y' => $y));	
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
	
	
	
	
	private function setLabelId($labelId) { $this->labelId = $labelId; }
	private function getLabelId() { return $this->labelId; }
	
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
	
	
	private function setMediumId($mediumId) { $this->mediumId = $mediumId; }
	private function getMediumId() { return $this->mediumId; }
	
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