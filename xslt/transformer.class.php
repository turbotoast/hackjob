<?php

class HackJob_Xslt_Transformer
{
	public static function transformDoc(DOMDocument $doc, $xsltFile, $xslParams = array())
	{
		$xp = new XSLTProcessor();
		$xp->setParameter('', $xslParams);
		
		$xsl = new DOMDocument();
		$xsl->load($xsltFile);
		
		$xp->importStylesheet($xsl);
		
		return $xp->transformToXML($doc);
	}
	
	public static function toDomElement($data, $name = null, DOMDocument $doc = null)
	{
		if($doc === null)
		{
			$doc = new DOMDocument();
		}
		
		if($name === null)
		{
			$name = is_object($data) ? get_class($data) : 'node';
		}
		
		if(is_object($data) && $data instanceof HackJob_Xslt_DomExportInterface)
		{
			$node = $data->toDomElement($name, $doc);
		}
		
		if(!isset($node))
		{
			$node = $doc->createElement($name);
			
			if(is_string($data) || is_int($data))
			{
					$node->appendChild($doc->createTextNode($data));
			}
			else if(is_object($data) || is_array($data))
			{
				foreach($data as $key => $value)
				{
					if(!is_string($key))
					{
						$key = null;
					}
					$node->appendChild(self::toDomElement($value, $key, $doc));
				}
			}
		}
		
		return $node;
	}
}

?>