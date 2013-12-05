<?php

/**
 *
 * @author Philipp Zimmermann
 *
 *
 */

abstract class DBModel
{
    protected $_table;
    protected $db;
    protected $id;



	public function __construct($id = 0){
    	$this->db = Database::getInstance();
    	if($id != 0){

    		$bind = array();
    		$q = 'SELECT * FROM '.$this->_table.' WHERE id = :id';

    		$bind[':id'] = $id;

    		$stmt = $this->db->prepare($q);
    		$stmt->execute($bind);
    		$rows = $stmt->fetchAll();

    		//$rows = $this->db->getAll($q, $bind);

    		if (0 === count($rows)) {
    			$this->id = 0;
    		}else{
    			foreach ($rows[0] as $key => $value){
    				$functionName = "set".ucfirst($key);
    				$this->$functionName($value);
    			}
    		}
    	}else{
    		$this->setId(0);
    	}
    }



    protected static function find($sql, $bind = null){
    	$db = Database::getInstance();
    	$stmt = $db->prepare($sql);
    	$stmt->execute($bind);
    	$rows = $stmt->fetchAll();
    	$result = array();
    	foreach($rows as $row){
    		$result[] = new self($row['id']);
    	}
    	return $result;
    }

    public function delete(){

    	$bind = array();
    	$q = 'DELETE FROM '.$this->_table.' WHERE id = :id';
    	$bind[':id'] = $this->id;
    	$stmt = $this->db->prepare($q);
    	$stmt->execute($bind);
    	unset($this);
    }

    public abstract function save();

    protected function doSave($attributes = null){
    	if(!is_array($attributes)){
	    	$stmt = $this->db->prepare('DESCRIBE '. $this->_table);
	    	$stmt->execute();


	    	$attributes = array();
	    	$rows = $stmt->fetchAll();
	    	foreach($rows as $row){
	    		if($row['Field'] != 'id'){
	    			$attributes[] = $row['Field'];
	    		}
	    	}
    	}

    	$bind = array();

    	$keys = '';
    	$values = '';
    	foreach ($attributes as $attribute){
    		//$bind[] = $this->{$attribute};
    		$functionName = "get".ucfirst($attribute);
    		$bind[':' .  $attribute] = $this->$functionName();
    	}

    	if($this->id === 0){
    		foreach ($attributes as $attribute){
    			$keys.= ($keys == '') ? '`'.$attribute.'`' : ',`'.$attribute.'`';
    			$values.= ($values == '') ? ':'.$attribute : ',:' . $attribute;
    		}
    		$q = 'INSERT INTO '.$this->_table.' ('.$keys.') VALUES ('.$values.')';

    	}else{
    		foreach ($attributes as $attribute){
    			$values.= ($values == '') ? '`'.$attribute.'` = :' . $attribute : ',`'.$attribute.'` = :' . $attribute;
    		}
    		$q = 'UPDATE '.$this->_table.' SET '.$values.' WHERE id = :id';
    		$bind[':id'] = $this->id;
    	}

    	$stmt = $this->db->prepare($q);
    	$stmt->execute($bind);
    	if($this->id === 0){
    		$this->setId($this->db->lastInsertId());
    	}
    }

    /**
     * @return the $id
     */
    public function getId() {
    	return $this->id;
    }

    /**
     * @param field_type $id
     */
    public function setId($id) {
    	$this->id = $id;
    }

    /**
     * @see http://www.php.net/manual/en/datetime.formats.php
     *
     * @param String $dateStr DateTime compatible date format string.
     * @return String MySQL comaptime date time format.
     */
    protected function toMySqlDateTime($dateStr) {
		if(is_string($dateStr) && (null != $dateStr)) {
    		$date = new DateTime($dateStr);
			$dateStr = $date->format('Y-m-d H:i:s');
    	}
    	return $dateStr;
    }

}