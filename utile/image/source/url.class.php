<?php

class HackJob_Utile_Image_Source_URL
	extends HackJob_Utile_Image_Source_FileSystem
{
	public function __construct($url)
	{
		$fileName = '/tmp/' . md5('source_url' . microtime());

		file_put_contents($fileName, file_get_contents($url));
		
		parent::__construct($fileName);
	}
}

?>