<?php

abstract class HackJob_Core_Controller
{
	protected $matches;
	
	public function __construct($matches)
	{
		$this->matches = $matches;
	}
	
	protected function getXSLTParams()
	{
		return array();
	}
	
	protected function appendProviderContent(DOMDocument $doc, HackJob_Request_Request $request)
	{
		$rootNode = $doc->documentElement;
		$providerContentNode = $rootNode->appendChild($doc->createElement('providercontent'));
		
		foreach(HackJob_Conf_Provider::get('CONTENT_PROVIDER_CLASSES', array()) as $className)
		{
			$instance = new $className();
			$providerContentNode->appendChild($instance->getContent($doc, $request));
		}
	}
	
	protected function docResponse($doc, $request, $template = null, $params = array())
	{
		$params = array_merge($params, $this->getXSLTParams());
		
		$this->appendProviderContent($doc, $request);
		
		if(isset($_GET['xmldump']) && HackJob_Conf_Provider::get('ENABLE_XMLDUMP', false))
		{
			header('Content-type: text/xml');
			echo $doc->saveXML();
			die;
		}
		
		$content = HackJob_Xslt_Transformer::transformDoc($doc, $template, $params);
		return new HackJob_Response_OK($content);
	}
	
	protected function getDoc()
	{
		$doc = new DOMDocument();
		$doc->appendChild($doc->createElement('root'));
		
		return $doc;
	}
	
	abstract public function response(HackJob_Request_Request $request);
}

?>