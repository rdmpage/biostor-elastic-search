<?php


/*

Create mapping for parent-child relationship bwtween work and page


*/

require_once (dirname(__FILE__) . '/elastic.php');

$json= '{
	"page": {
		"_parent": {
			"type": "work"
		}
	}
}';

$obj = json_decode($json);

print_r($obj);

echo "Delete\n";
// Delete index 
$elastic->send('DELETE');

echo "Recreate\n";
// Recreate index 
$elastic->send('PUT');

echo "Mapping\n";
// Mapping
$elastic->send('PUT', '_mapping/page', json_encode($obj));



?>
