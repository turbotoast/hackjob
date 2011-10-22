<?php

abstract class HackJob_Utile_Image_Transformer_Base
{
	protected $source;
	
	public function __construct(HackJob_Utile_Image_Source_Base $source)
	{
		$this->source = $source;	
	}
	
	abstract public function doTransformation();
}

?>