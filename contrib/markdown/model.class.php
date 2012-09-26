<?php

abstract class HackJob_Contrib_Markdown_Model
	extends HackJob_Model_Base
{
	abstract public function getMarkdownFields();

	public function toDomElement($name, DOMDocument $doc)
	{
		$node = parent::toDomElement($name, $doc);
		
		foreach($this->getMarkdownFields() as $field)
		{
			$mdNodeName = $field . '_md';
			$mdNodeContent = HackJob_Contrib_Markdown_Parser::parse($this->$field);
			
			$node->appendChild(
				HackJob_Xslt_Transformer::toDomElement($mdNodeContent, $mdNodeName, $doc));
		}
		
		return $node;
	}
}

?>