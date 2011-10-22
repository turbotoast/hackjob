<?php

abstract class HackJob_Utile_Image_Source_Base
{
	const ORIENTATION_LANDSCAPE = 1;
	const ORIENTATION_PORTRAIT = 2;
	const ORIENTATION_SQUARE = 3;
	
	protected $im;
	protected $information;
	public $orientation;
	
	public function __construct()
	{
		$this->readImage();
		
		if($this->width > $this->height)
			$this->orientation = self::ORIENTATION_LANDSCAPE;
		elseif($this->width < $this->height)
			$this->orientation = self::ORIENTATION_PORTRAIT;
		else
			$this->orientation = self::ORIENTATION_SQUARE;
	}
	
	public function getInformation()
	{
		return $this->information;
	}
	
	public function __get($name)
	{
		if(in_array($name, array('width','height','type','mime')))
		{
			$info = $this->getInformation();
			return $info[$name];
		}
		
		throw new HackJob_Core_Exception('Property ' . $name . ' not found!');
	}
	
	abstract public function readImage();
	public function getImageResource()
	{
		return $this->im;
	}
}

?>