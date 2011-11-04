<?php

class HackJob_Contrib_CRUD_Mapper
	extends HackJob_Routing_Mapper
{
	public function getControllerMapping()
	{
		return array(
			'%/\w+/media/(?P<mediaName>[^/]+)$%' => array('HackJob_Contrib_CRUD_Controller', 'mediaResponse'),
			'%/\w+/(?P<appName>\w+)/new/$%' => array('HackJob_Contrib_CRUD_Controller', 'newResponse'),
			'%/\w+/(?P<appName>\w+)/save/$%' => array('HackJob_Contrib_CRUD_Controller', 'saveResponse'),
			'%/\w+/(?P<appName>\w+)/edit/(?P<modelId>\d+)/$%' => array('HackJob_Contrib_CRUD_Controller', 'editResponse'),
			'%/\w+/(?P<appName>\w+)/del/(?P<modelId>\d+)/$%' => array('HackJob_Contrib_CRUD_Controller', 'deleteResponse'),
			'%/\w+/(?P<appName>\w+)/$%' => array('HackJob_Contrib_CRUD_Controller', 'response'),
			'%/\w+/$%' => array('HackJob_Contrib_CRUD_Controller', 'indexResponse')
		);
	}	
}

?>