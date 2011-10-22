<?php

interface HackJob_ContentProvider_Interface
{
	public function __construct();
	public function getContent(DOMDocument $doc, HackJob_Request_Request $request);
}

?>