<?php

class HackJob_Contrib_BlandPage_Controller
	extends HackJob_Core_Controller
{
	public function response(HackJob_Request_Request $request)
	{
		$slug = $this->pathToSlug($this->matches['path']);
		
		if(empty($slug))
		{
			$slug = 'index';
		}
		$templatePath = HackJob_Conf_Provider::get(
			'HACKJOB_CONTRIB_BLANDPAGE_TEMPLATE_PATH',
			realpath(dirname(__FILE__)) . '/../../../../templates/'
		);
		$template = $templatePath . $slug . '.xslt';

		if(!file_exists($template))
		{
			return null;
		}
		
		return $this->docResponse($this->getDoc(), $request, $template);
	}
	
	private function pathToSlug($path)
	{
		$path = ltrim($path, '/');
		return rtrim($path, '/');
	}
} 

?>