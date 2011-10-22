<?php

abstract class HackJob_Middleware_Base
{
	public function __construct() {}

	public function request(HackJob_Request_Request $request)
	{
		return $request;
	}
	public function response(HackJob_Request_Request $request, HackJob_Response_Base $response) 
	{
		return $response;
	}
}

?>