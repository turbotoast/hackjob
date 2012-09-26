<?php

require_once(realpath(dirname(__FILE__)) . '/php_markdown.php');

class HackJob_Contrib_Markdown_Parser
{
	public static function parse($string)
	{
		return Markdown($string);
	}
}

?>