<?php

class HackJob_ContentProvider_BasePath
	implements HackJob_ContentProvider_Interface
{
	public function __construct() {}
	
	public function getContent(DOMDocument $doc, HackJob_Request_Request $request)
	{
		return HackJob_Xslt_Transformer::toDomElement(HackJob_Conf_Provider::get('BASEPATH'), 'basepath', $doc);
	}
}

?>