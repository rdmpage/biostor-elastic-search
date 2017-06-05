<?php

// Store BioStor article and OCR text

require_once (dirname(__FILE__) . '/config.inc.php');
require_once (dirname(__FILE__) . '/lib.php');
require_once (dirname(__FILE__) . '/elastic.php');



//----------------------------------------------------------------------------------------
function fetch_page($PageID)
{	
	$page = null;
	
	$parameters = array(
		'op' => 'GetPageMetadata',
		'pageid' => $PageID,
		'ocr' => 'true',
		'names' => 'true',
		'format' => 'json',
		'apikey' => '0d4f0303-712e-49e0-92c5-2113a5959159'
	);
	
	$url = 'http://www.biodiversitylibrary.org/api2/httpquery.ashx?' . http_build_query($parameters);
		
	$json = get($url);
	
	if ($json != '')
	{
		$obj = json_decode($json);
		if (isset($obj->Result))
		{
			$page = $obj->Result;
		}
	}
	
	return $page;
}


$biostor = 60645;

$biostor = 146658; // New Uraniidae, Drepanulidae and Geometridae from British New Guinea

$url = 'http://biostor.org/api.php?id=biostor/' . $biostor . '&format=citeproc';
$json = get($url);

$obj = json_decode($json);

// add BioStor article (CSL)
$elastic->send('PUT', 'work/' . $biostor, json_encode($obj));


//$PageID = 15771439;
$PageID = 15771440;

$page = fetch_page($PageID);

if ($page)
{
	// index/id?parent=
	$elastic->send('PUT', 'page/' . $PageID . '?parent=' . $biostor, json_encode($page));
//	$elastic->send('PUT', 'page/' . $PageID , json_encode($page));
	//print_r($page);
}

///----

$biostor = 60645; // New Indian Epiplemidae and Geometridae

$url = 'http://biostor.org/api.php?id=biostor/' . $biostor . '&format=citeproc';
$json = get($url);

$obj = json_decode($json);

// add BioStor article (CSL)
$elastic->send('PUT', 'work/' . $biostor, json_encode($obj));

$PageID = 3218502;

$page = fetch_page($PageID);

if ($page)
{
	// index/id?parent=
	$elastic->send('PUT', 'page/' . $PageID . '?parent=' . $biostor, json_encode($page));
	//print_r($page);
}



?>
