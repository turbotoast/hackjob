<?php

class HackJob_Contrib_CRUD_Field
{
	const TYPE_TEXT = 'text';
	const TYPE_TEXTAREA = 'textarea';
	
	public $showInList = true;
	public $editable = true;
	public $name;
	public $field;
	public $type = HackJob_Contrib_CRUD_Field::TYPE_TEXT;
}

?>