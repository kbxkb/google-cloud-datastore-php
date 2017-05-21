<?php
require 'vendor/autoload.php';
use Google\Auth\ApplicationDefaultCredentials;
use Google\Cloud\Datastore\DatastoreClient;

try
{
	$projectId = 'triple-cab-162115';
	$datastore = new DatastoreClient([
	    'projectId' => $projectId
	]);

	echo 'Matches:<br/>';
	$queryval = $_GET['searchtext'];
	if ($queryval[0]) {
		$upperlimit = $queryval . json_decode('"\ufffd"');
		$query = $datastore->query()
			->kind('SKU')
			->filter('name', '>=', $queryval)
			->filter('name', '<', $upperlimit)
			->order('name');
		$result = $datastore->runQuery($query);
		foreach ($result as $SKU) {
			echo $SKU['name'];
			echo '<br/>';
		}
	}
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
