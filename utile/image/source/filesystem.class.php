<?php

class HackJob_Utile_Image_Source_Filesystem
	extends HackJob_Utile_Image_Source_Base
{
	protected $fileName;
	
	public function __construct($fileName)
	{
		$this->fileName = $fileName;
		
		if(!is_file($this->fileName))
		{
			throw new HackJob_Utile_Image_Source_Exception(
				'Invalid filename: ' . $fileName
			);
		}

		$this->information = array();
		$info = getimagesize($this->fileName);
		$this->information['width'] = $info[0];
		$this->information['height'] = $info[1];
		$this->information['type'] = $info[2];
		$this->information['mime'] = $info['mime'];
		
		parent::__construct();
	}
	
	public function readImage()
	{
		$this->im = imagecreatefromstring(
			file_get_contents($this->fileName)
		);
	}
}

?>