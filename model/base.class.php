<?php

abstract class HackJob_Model_Base
	implements HackJob_Xslt_DomExportInterface
{
	protected $_id;
	protected $_className;
	
	public function __construct($className, $param)
	{
		$this->_className = $className;
		
		if(is_array($param))
		{
			return $this->constructByRow($param);
		}
		
		if(is_string($param))
		{
			$param = (int)$param;
		}
		if(is_int($param))
		{
			return $this->getById($param);
		}
	}
	
	protected static function findOne($class, $filters)
	{
		if(!is_array($filters))
		{
			$filters = array($filters);
		}
		
		$instance = new $class();
		$sql = "
			SELECT *
			FROM	`" . $instance->getTableName() ."`
			WHERE
		";
		$sql .= implode(' AND ', $filters);
		$stmt = HackJob_Db_Provider::getInstance()->prepare($sql);
		
		foreach($filters as $filter)
		{
			$stmt->bindParam(':' . $filter->fieldName, $filter->filterValue);
		}
		
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		
		if(count($result) == 0)
		{
			throw new HackJob_Model_Exception_NotFound('No object of class ' .$class . ' found!');
		}
		if(count($result) > 1)
		{
			throw new HackJob_Model_Exception_MoreThanOneFound('More than one object of class ' . $class . ' found!');
		}
		
		return new $class(array_pop($result));
	}
	
	protected static function find($class, $filters = null, $orderColumn = 'id ASC', $limit = 0, $offset = 0)
	{
		if(!is_null($filters))
		{
			if(!is_array($filters))
			{
				$filters = array($filters);
			}
		}
		
		$instance = new $class();
		$sql = "
			SELECT *
			FROM	`" . $instance->getTableName() ."`
		";
		
		if($filters)
		{
			$sql .= " WHERE ";
			$sql .= implode(' AND ', $filters);
		}
		$sql .= ' ORDER BY ' . $orderColumn;
		
		if($limit)
		{
			$sql .= " LIMIT " . $limit;
		}
		if($offset)
		{
			$sql .= " OFFSET " . $offset;
		}
		
		$stmt = HackJob_Db_Provider::getInstance()->prepare($sql);
		
		if(!is_null($filters))
		{
			foreach($filters as $filter)
			{
				$stmt->bindParam(':' . $filter->fieldName, $filter->filterValue);
			}
		}
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$stmt->closeCursor();
		$models = array();
		foreach($result as $row)
		{
			$models[] = new $class($row);
		}
		
		return $models;
	}
	
	protected function getDeleteStatement()
	{
		$sql = "
			DELETE FROM	`" . $this->getTableName() . "`
			WHERE `id` = :id
		";
		
		return HackJob_Db_Provider::getInstance()->prepare($sql);
	}
	
	public function delete()
	{
		$stmt = $this->getDeleteStatement();
		$stmt->bindParam(':id', $this->getId(), PDO::PARAM_INT);
		$stmt->execute();
		
		foreach($this->getFields() as $field)
		{
			$this->$field = null;
		}
	}
	
	
	
	protected function getUpdateStatement()
	{
		$sql = "
			UPDATE	`" . $this->getTableName() . "`
			SET		";
		
		$fields = array();
		foreach($this->getFields() as $field)
		{
			$fields[] = '`' . $field . '` = :' . $field;
		}
		$sql .= implode($fields, ', ');
		$sql .= ' WHERE	`id` = :id';
		
		return HackJob_Db_Provider::getInstance()->prepare($sql);
	}
	
	protected function getCreateStatement()
	{
		$sql = "INSERT INTO	`"  . $this->getTableName() . "`";
		$sql .= " (`" . implode('`,`', $this->getFields()) . "`)";
		$sql .= " VALUES (:" . implode(',:', $this->getFields()) . ")";
		
		return HackJob_Db_Provider::getInstance()->prepare($sql);
	}
	
	public function save()
	{
		if($this->isInDb())
		{
			$stmt = $this->getUpdateStatement();
			$stmt->bindParam(':id', $this->getId(), PDO::PARAM_INT);
		}
		else
		{
			$stmt = $this->getCreateStatement();
		}
		
		foreach($this->getFields() as $key)
		{
			$stmt->bindParam(':' . $key, $this->$key);
		}
		
		$stmt->execute();
		
		if($this->_id === null)
		{
			$this->_id = HackJob_Db_Provider::getInstance()->getPDO()->lastInsertId();
		}
	}
	
	protected function getSelectByIdStatement()
	{
		$sql = "
			SELECT	*
			FROM	`" . $this->getTableName() . "`
			WHERE	`id` = :id
		";
		
		return HackJob_Db_Provider::getInstance()->prepare($sql);
	}
	
	abstract function getTableName();
	
	public function getFields()
	{
		$fields = array();
		
		foreach($this as $fieldName => $fieldValue)
		{
			if($fieldName[0] != '_')
			{
				$fields[] = $fieldName;
			}
		}
		
		return $fields;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	protected function getById($id)
	{
		$stmt = $this->getSelectByIdStatement();
		
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$this->fillByStatement($stmt);
	}
	
	public function isInDb()
	{
		return (bool)$this->getId();
	}
	
	protected function setId($id)
	{
		$this->_id = $id;
	}
	
	protected function fillByStatement(PDOStatement $stmt)
	{
		$stmt->execute();
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		
		$this->constructByRow($row);
	}
	
	protected function constructByRow($param)
	{
		foreach($param as $key => $value)
		{
			if($key == 'id')
			{
				$this->setId($value);
				continue;
			}
			$this->$key = $value;
		}
	}
	
	public function toDomElement($name, DOMDocument $doc)
	{
		if($doc === null)
		{
			$doc = new DOMDocument();
		}
		
		if($name === null)
		{
			$name = $this->_className;
		}
		
		$node = $doc->createElement($name);
		
		foreach($this->getFields() as $property)
		{
			$value = $this->$property;
			$node->appendChild(HackJob_Xslt_Transformer::toDomElement($value, $property, $doc));
		}
		
		$node->appendChild(HackJob_Xslt_Transformer::toDomElement($this->getId(), 'id', $doc));
		
		return $node;
	}
}

?>