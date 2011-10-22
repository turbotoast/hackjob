<?php

class HackJob_Error_Handler
{
	public static function handlePHPError($errno, $errstr)
	{
		$exception = new HackJob_Error_Exception($errstr, $errno);
		throw $exception;
	}
	
	public function handleException(Exception $e)
	{
		echo '<h1>Exception occured</h1>';
		echo '<h2>Type: ' . get_class($e) . '</h2>';
		echo '<h3>Message</h3>';
		echo '<p>' . $e->getMessage() . '</p>';
		echo '<pre>' . $e->getTraceAsString() . '</pre>';
		die;
	}
}

?>