<?php

class HackJob_Utile_Image_Transformer_ResizeSquare
	extends HackJob_Utile_Image_Transformer_Resize
{
	protected $edge;
	
	public function __construct(
		HackJob_Utile_Image_Source_Base $source, $edge)
	{
		$this->edge = $edge;
		switch($source->orientation)
		{
			case HackJob_Utile_Image_Source_Base::ORIENTATION_LANDSCAPE:
				$factor = $edge / $source->height;
				break;
			case HackJob_Utile_Image_Source_Base::ORIENTATION_PORTRAIT:
			case HackJob_Utile_Image_Source_Base::ORIENTATION_SQUARE:
				$factor = $edge / $source->width;
				break;
		}
		$width = $source->width * $factor;
		$height = $source->height * $factor;
		
		parent::__construct($source, $width, $height);
	}	
	
	public function doTransformation()
	{
		$resizedResult = parent::doTransformation();
	
		$x = ($this->width - $this->edge) / 2;
		$y = ($this->height - $this->edge) / 2;
		
		$croppedResult = imagecreatetruecolor($this->edge, $this->edge);
		imagecopy(
			$croppedResult,
			$resizedResult,
			0,
			0,
			$x,
			$y,
			$this->edge,
			$this->edge
		);
		return $croppedResult;
	}
}

?>