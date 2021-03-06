<?php

// $Id: //

/**
 * @file config.php
 *
 * Global configuration variables (may be added to by other modules).
 *
 */

global $config;

// Date timezone
date_default_timezone_set('UTC');


// Proxy settings for connecting to the web-----------------------------------------------
// Set these if you access the web through a proxy server. 
$config['proxy_name'] 	= '';
$config['proxy_port'] 	= '';

//$config['proxy_name'] 	= 'wwwcache.gla.ac.uk';
//$config['proxy_port'] 	= '8080';


// Elastic--------------------------------------------------------------------------------
$config['elastic_options'] = array(
		'index' => 'bib',
		'protocol' => 'http',
		'host' => '192.168.99.100',
		'port' => 32769
		);

// Bitnami https://google.bitnami.com/vms/bitnami-elasticsearch-dm-4693
$config['elastic_options'] = array(
		'index' => 'elasticsearch/biostor',
		'protocol' => 'http',
		'host' => '130.211.107.26',
		'port' => 80
		);
	
?>