<?php
class HackJob_Utile_String
{
	protected $string;
	
	public function __construct($string)
	{
		$this->string = $string;	
	}
	
	public function __toString()
	{
		return $this->getString();
	}
	
	public function toSlug()
	{
		$string = $this->string;
		
		$string = strtolower($string);
		$string = preg_replace('%[^a-z0-9-\s/.\']+%','',$string);
		$string = trim($string);
		$string = preg_replace('%[\s\']+%','-', $string);
		
		$this->string = $string;
		return $this;
	}
	
	public function getString()
	{
		return $this->string;
	}
	
}