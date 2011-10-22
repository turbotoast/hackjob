<?php

class HackJob_Response_Redirect
	extends HackJob_Response_Base
{
	public function __construct($redirectTo, $withBasePath = true)
	{
		if($withBasePath)
		{
			$redirectTo = HackJob_Conf_Provider::get('BASEPATH') . $redirectTo;
		}
		$redirectHeader = 'Location: ' . $redirectTo;
		parent::__construct('', array($redirectHeader), 301);
	}
}

?>