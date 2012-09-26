<?php

class HackJob_Contrib_Blandpage_MarkdownResolver
	extends HackJob_Core_Controller
{
	private $slug;

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}
	
	public function response(HackJob_Request_Request $request)
	{
		$templatePath = HackJob_Conf_Provider::get(
			'HACKJOB_CONTRIB_BLANDPAGE_TEMPLATE_PATH',
			realpath(dirname(__FILE__)) . '/../../../../markdown/'
		);
		$mdFile = $templatePath . $this->slug . '.md';

		if(!file_exists($mdFile))
		{
			return null;
		}
		
		$doc = $this->getDoc();
		$mdContent = utf8_decode(file_get_contents($mdFile));
		$markdown = HackJob_Contrib_Markdown_Parser::parse($mdContent);
		
		$importDoc = new DOMDocument();
		$importDoc->loadHTML($markdown);
		
		$this->prependLinksWithBasePath($importDoc);
		$this->prependImagesWithBasePath($importDoc);
				
		$node = $importDoc->getElementsByTagName('body')->item(0);
		
		$doc->documentElement->appendChild(
			$doc->importNode($node, true));
		
		$template = HackJob_Conf_Provider::get('HACKJOB_CONTRIB_BLANDPAGE_MARKDOWN_BASE_TEMPLATE');
		
		return $this->docResponse($doc, $request, $template, array('slug' => $this->slug));
	}
	
	private function prependImagesWithBasePath(DomDocument $importDoc)
	{
		$images = $importDoc->getElementsByTagName('img');
		$basePath = HackJob_Conf_Provider::get('BASEPATH');
		foreach($images as $image)
		{
			$src = $image->getAttribute('src');
			if(strpos($src, '/') === 0)
			{
				$src = $basePath . $src;
				$image->setAttribute('src', $src);
			}
		}
	}
	
	private function prependLinksWithBasePath(DomDocument $importDoc)
	{
		$links = $importDoc->getElementsByTagName('a');
		$basePath = HackJob_Conf_Provider::get('BASEPATH');
		foreach($links as $link)
		{
			$href = $link->getAttribute('href');
			if(strpos($href, '/') === 0)
			{
				$href = $basePath . $href;
				$link->setAttribute('href', $href);
			}
		}
	}
}

?>