<?php

class HackJob_ContentProvider_Request
	implements HackJob_ContentProvider_Interface
{
	public function __construct() {}
	
	public function getContent(DOMDocument $doc, HackJob_Request_Request $request)
	{
		$node = $doc->createElement('request');
		$node->setAttribute('is_post', $request->isPost() ? 'true' : 'false');
		$node->setAttribute('request_uri', $request->getRequestUri());
		

		$node->appendChild(HackJob_Xslt_Transformer::toDomElement($_POST,'post',$doc));
		$node->appendChild(HackJob_Xslt_Transformer::toDomElement($_GET,'get',$doc));
		return $node;
	}
}

?>