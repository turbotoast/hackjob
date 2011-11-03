<?php

class HackJob_Contrib_ContentFragment_CRUDDescription
	extends HackJob_Contrib_CRUD_Description
{
	public $allowNew = false;
	
	public function getFields()
	{
		$fields = array();

		$handle = new HackJob_Contrib_CRUD_Field();
		$handle->showInList = false;
		$handle->name = 'Name';
		$handle->field = 'handle';
		$handle->editable = false;
		$fields[] = $handle;
		
		$description = new HackJob_Contrib_CRUD_Field();
		$description->name = 'Beschreibung';
		$description->field = 'description';
		$description->editable = false;
		$description->type = HackJob_Contrib_CRUD_Field::TYPE_TEXTAREA;
		$fields[] = $description;
		
		$content = new HackJob_Contrib_CRUD_Field();
		$content->showInList = true;
		$content->name = 'Inhalt';
		$content->field = 'content';
		$content->type = HackJob_Contrib_CRUD_Field::TYPE_TEXTAREA;
		$fields[] = $content;
		
		return $fields;
	}
	
	public function getModelClassName()
	{
		return 'HackJob_Contrib_ContentFragment_Model';
	}
	
	public function getModelList()
	{
		return HackJob_Contrib_ContentFragment_Model::findAll();
	}
	
	public function getAppName()
	{
		return 'Content';
	}	
	
	public function getAppSlug()
	{
		return 'content';
	}
}

?>