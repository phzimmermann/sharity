<?php

class Label extends DBModel{

	private $name;

	public function __construct($id = 0){
		$this->_table = 'labels';
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
	
	public static function getAll(){
		return self::findAll('SELECT * FROM labels');
	}
	
	
	public static function findByName($name, $exact = true){
		if($exact){
			return self::findAll('SELECT id FROM labels WHERE `name` = :name;', array(':name' => $name));
		}else{
			return self::findAll('SELECT id FROM labels WHERE `name` LIKE :name;', array(':name' => '%'.$name.'%'));
		}
	}
	
	public static function findByProduct($product){
		return self::findAll('SELECT l.id FROM labels AS l INNER JOIN label_mediums as lm ON(lm.labelId = l.id) WHERE lm.mediumId = :medium_id;', array(':medium_id' => $product->getId()));
		
	}
	
	
	public function __toString(){
		return $this->getName();
	}
	
	
	
	
	public function save(){
		parent::doSave();
	}
	
	
	
	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	
	

}
?>