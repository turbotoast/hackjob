<?php

class HackJob_Response_OK
	extends HackJob_Response_Base
{
	public function __construct($content, $headers = array())
	{
		parent::__construct($content, $headers, 200);
	}
}

?>