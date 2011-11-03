<?php

class HackJob_Contrib_CRUD_Controller
	extends HackJob_Core_Controller
{
	private $description;
	private $descriptions;
	
	protected function getDescriptions()
	{
		if($this->descriptions === null)
		{		
			$this->descriptions = array();
			foreach(HackJob_Conf_Provider::get('HACKJOB_CONTRIB_CRUD_DESCRIPTIONS') as $className)
			{
				$instance = new $className();
				$slug = $instance->getAppSlug();
				$this->descriptions[$slug] = $instance;
			}	
		}
		
		return $this->descriptions;
	}
	
	protected function getXSLTParams()
	{
		return array(
			'crud_slug' => HackJob_Conf_Provider::get('HACKJOB_CONTRIB_CRUD_SLUG'),
			'basepath' => HackJob_Conf_Provider::get('BASEPATH'),
		);
	}
	
	protected function getDescription($slug)
	{
		$descriptions = $this->getDescriptions();
		return $descriptions[$slug];
	}

	public function response(HackJob_Request_Request $request)
	{
		$crudSlug = HackJob_Conf_Provider::get('HACKJOB_CONTRIB_CRUD_SLUG');
		$requestUri = $request->getRequestUri();
		
		$path = substr($requestUri, strpos($requestUri, $crudSlug) + strlen($crudSlug) + 1);
		$path = rtrim($path, '/');
		
		if(!$path)
		{
			return $this->indexResponse($request);
		}
		
		$pathSegments = explode('/', $path);
		$segment = array_shift($pathSegments);
		
		if($segment == 'css')
		{
			return $this->cssResponse($request);
		}
		
		$this->description = $this->getDescription($segment);
		
		if(!$pathSegments)
		{
			return $this->listResponse($request);
		}
		
		$action = array_shift($pathSegments);

		switch($action)
		{
			case 'new': return $this->newResponse($request);
			case 'edit': return $this->editResponse($request, array_shift($pathSegments));
			case 'del': return $this->deleteResponse($request, array_shift($pathSegments));
			case 'save': return $this->save($request);
		}
	}
	
	public function cssResponse(HackJob_Request_Request $request)
	{
		$css = file_get_contents(realpath(dirname(__FILE__)) . '/media/crud.css');
		header('Content-type: text/css');
		echo $css;
		die;
	}
	
	public function deleteResponse(HackJob_Request_Request $request, $id)
	{
		$className = $this->description->getModelClassName();
		$model = new $className($id);
		$model->delete();
		
		return new HackJob_Response_Redirect('../..');
	}
	
	public function save(HackJob_Request_Request $request)
	{
		$className = $this->description->getModelClassName();
		
		if(isset($_POST['crud']['id']))
		{
			$id = $_POST['crud']['id'];
			unset($_POST['crud']['id']);
			$model = new $className($id);
		}
		else
		{
			$model = new $className();
		}
		
		foreach($_POST['crud'] as $key => $value)
		{
			$model->$key = $value;
		}

		$model->save();
		
		return new HackJob_Response_Redirect('..');
	}
	
	public function newResponse(HackJob_Request_Request $request)
	{
		if(!$this->description->allowNew)
		{
			return new HackJob_Response_NotFound('');
		}
		
		$template = realpath(dirname(__FILE__)) . '/tpl/new.xslt';
		$doc = $this->getDoc();
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement($this->description, 'description', $doc)
		);
		return $this->docResponse($doc, $request, $template);
	}
	
	public function editResponse(HackJob_Request_Request $request, $id)
	{
		$template = realpath(dirname(__FILE__)) . '/tpl/edit.xslt';
		$doc = $this->getDoc();
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement($this->description, 'description', $doc)
		);
		
		$className = $this->description->getModelClassName();
		$model = new $className($id);
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement($model, 'model', $doc)
		);
		
		return $this->docResponse($doc, $request, $template);
	}
	
	public function listResponse(HackJob_Request_Request $request)
	{
		$template = realpath(dirname(__FILE__)) . '/tpl/list.xslt';

		$models = $this->description->getModelList();
		$doc = $this->getDoc();
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement($models, 'list', $doc)
		);
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement($this->description, 'description', $doc)
		);

		return $this->docResponse($doc, $request, $template);
	}
	
	public function indexResponse(HackJob_Request_Request $request)
	{
		$template = realpath(dirname(__FILE__)) . '/tpl/index.xslt';
		
		$doc = $this->getDoc();
		$descriptions = $this->getDescriptions();
		
		$doc->documentElement->appendChild(
			HackJob_Xslt_Transformer::toDomElement(
				$descriptions, 'descriptions', $doc
		));

		return $this->docResponse($doc, $request, $template);
	}	
}

?>