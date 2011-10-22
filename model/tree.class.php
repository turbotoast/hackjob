<?php

abstract class HackJob_Model_Tree
	extends HackJob_Model_Base
{
	public $parent_id;

	public function hasParent()
	{
		return $this->parent_id !== NULL;
	}
	
	public function getParent()
	{
		return new Category_Model($this->parent_id);
	}
	
	public function getChildren()
	{
		return parent::find($this->_className, new HackJob_Db_Filter('parent_id', $this->getId()));
	}
}

?>