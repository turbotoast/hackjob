<?php

interface HackJob_Xslt_DomExportInterface
{
	public function toDomElement($name, DOMDocument $doc);
}

?>