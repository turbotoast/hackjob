<?php

abstract class HackJob_Contrib_CRUD_Description
	implements HackJob_Xslt_DomExportInterface
{
	public $allowNew = true;
	
	abstract public function getAppName();
	abstract public function getAppSlug();
	abstract public function getModelList();
	abstract public function getFields();
	abstract public function getModelClassName();
	
	public function toDomElement($name, DOMDocument $doc)
	{
		$node = $doc->createElement($name);
		$appNode = $node->appendChild($doc->createElement('app'));
		$appNode->appendChild(HackJob_Xslt_Transformer::toDomElement(
			$this->getAppName(), 'name', $doc));
		$appNode->appendChild(HackJob_Xslt_Transformer::toDomElement(
			$this->getAppSlug(), 'slug', $doc));
		
		$node->appendChild(HackJob_Xslt_Transformer::toDomElement(
			$this->allowNew, 'allowNew', $doc));	
		$node->appendChild(HackJob_Xslt_Transformer::toDomElement(
			$this->getFields(), 'fields', $doc));
			
		return $node;
	}
}

?>