<?php

class HackJob_Utile_Image_Transformer_Resize
	extends HackJob_Utile_Image_Transformer_Base
{
	protected $width;
	protected $height;
	
	public function __construct(
		HackJob_Utile_Image_Source_Base $source,
		$width, $height)
	{
		$this->width = $width;
		$this->height = $height;
		
		parent::__construct($source);	
	}
	
	public function doTransformation()
	{
		$result = imagecreatetruecolor($this->width, $this->height);
		
		$background = imagecolorallocate($result, 255, 255, 255);
		imagefilledrectangle($result, 0, 0, $this->width, $this->height, $background);
		
		imagecopyresampled(
			$result,							// Target image resource
			$this->source->getImageResource(),	// Source image resource
			0,									// X in the target
			0,									// Y in the target
			0,									// X in the source
			0,									// Y in the source
			$this->width,						// Target width
			$this->height,						// Target height
			$this->source->width,				// Source width
			$this->source->height				// Source height
		);
		
		return $result;
	}
}

?>