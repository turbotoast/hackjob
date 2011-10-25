<?php

class HackJob_Contrib_ContentFragment_Middleware
	extends HackJob_Middleware_Base
{
	private $doc;
	private $xPath;
	
	public function response(
		HackJob_Request_Request $request, 
		HackJob_Response_Base $response)
	{
		$this->getDoc($response);
		$this->getXPath();

		$nodes = $this->xPath->query('//hackjob:content_fragment');

		foreach($nodes as $node)
		{
			$this->replaceNode($node);
		}
		$response->content = $this->doc->saveHTML();
		
		return $response;
	}
	
	protected function replaceNode(DOMNode $node)
	{
		$handle = $node->getAttribute('handle');
		
		$isHTML = $node->hasAttribute('mode') && $node->getAttribute('mode') == 'html';
		
		$newNode = $this->getReplacementNode($handle, $isHTML);
		$node->parentNode->replaceChild($newNode, $node);
	}
	
	protected function getReplacementNode($handle, $isHTML = false)
	{
		$model = HackJob_Contrib_ContentFragment_Model::getByHandle($handle);
		$content = $model->content;

		if($isHTML)
		{
			$content = '<div>' . $content . '</div>';	
		}
		
		if($isHTML)
		{
			$importDoc = new DomDocument();
			$importDoc->loadXML($content);
		
			$importDoc->documentElement->setAttribute('class', 'content_fragment_editable ' . $handle);
			return $this->doc->importNode($importDoc->documentElement, true);	
		}

		return $this->doc->createTextNode($content);
	}
	
	protected function getXPath()
	{
		$this->xPath = new DOMXPath($this->doc);
		$this->xPath->registerNamespace('hackjob', 'http://joern-meyer.net/hackjob/');
	}
	
	protected function getDoc(HackJob_Response_Base $response)
	{
		$this->doc = new DOMDocument();
		$this->doc->loadXML($response->content);
	}
} 

?>