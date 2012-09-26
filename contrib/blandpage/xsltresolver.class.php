<?php

class HackJob_Contrib_BlandPage_XSLTResolver
	extends HackJob_Core_Controller
{
	private $slug;
	
	public function setSlug($slug)
	{
		$this->slug = $slug;
	}
	
	public function response(HackJob_Request_Request $request)
	{
		$templatePath = HackJob_Conf_Provider::get(
			'HACKJOB_CONTRIB_BLANDPAGE_TEMPLATE_PATH',
			realpath(dirname(__FILE__)) . '/../../../../templates/'
		);
		$template = $templatePath . $this->slug . '.xslt';

		if(!file_exists($template))
		{
			return null;
		}
		
		return $this->docResponse($this->getDoc(), $request, $template, array('slug' => $this->slug));
	}	
}

?>