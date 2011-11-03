<?php

class HackJob_Contrib_ContentFragment_Model
	extends HackJob_Model_Base
{
	public $handle;
	public $content;

	public function __construct($param = null)
	{
		parent::__construct(__CLASS__, $param);
	}
	
	public static function findAll()
	{
		return parent::find(__CLASS__);
	}
	
	public static function getByHandle($handle)
	{
		return parent::findOne(__CLASS__, new HackJob_Db_Filter('handle', $handle));
	}
	
	public function getTableName()
	{
		return 'content_fragment';
	}
}

?>