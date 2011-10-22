<?php
	require_once('lib/hackjob/autoloader.php');

	$configPaths = array(
		realpath(dirname(__FILE__)) . '/conf/middlewares.conf.php',
		realpath(dirname(__FILE__)) . '/conf/base.conf.php',
		realpath(dirname(__FILE__)) . '/conf/env.conf.php',
		realpath(dirname(__FILE__)) . '/conf/routing.conf.php',
	);
	HackJob_Conf_Provider::setConfig($configPaths);
	
	setlocale(
		LC_ALL, 'de_DE.UTF8'
	);
	
	$bootstrap = new HackJob_Core_Bootstrapper();

?>
