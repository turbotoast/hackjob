<?php

class HackJob_Request_Request
{
	private static $instance;
	
	protected $requestUri;
	public $registry;
	
	private function __construct() 
	{
		$this->requestUri = $_SERVER['REQUEST_URI'];
		$this->registry = array();
	}
	
	public function getRequestUri()
	{
		return $this->requestUri;
	}
	
	public function isPost()
	{
		return ($this->getRequestMethod() == 'POST');
	}
	
	public function getRequestMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	
	public function getIP()
	{
		return $_SERVER['REMOTE_ADDR'];
	}

	public static function getInstance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	
}

?>