<?php

class HackJob_Middleware_Session
	extends HackJob_Middleware_Base
{
	public function request(HackJob_Request_Request $request)
	{
		$sessionName = HackJob_Conf_Provider::get('SESSION_NAME', 'HackJob');
		session_name($sessionName);
		session_start();
		
		return parent::request($request);
	}
}

?>