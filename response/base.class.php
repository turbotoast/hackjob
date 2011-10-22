<?php

abstract class HackJob_Response_Base
{
	public $status;
	public $headers = array();
	public $content;
	
	public function __construct($content, $headers = array(), $status)
	{
		$this->content = $content;
		$this->headers = $headers;
		$this->status = $status;
		
		$contentHeader = 'Content-type: ' . HackJob_Conf_Provider::get('DEFAULT_CONTENT_TYPE', 'text/html');
		$contentHeader .= '; charset=' . HackJob_Conf_Provider::get('DEFAULT_CONTENT_CHARSET', 'utf8');
		$this->headers[] = $contentHeader;
	}
}

?>