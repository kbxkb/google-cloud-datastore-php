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

	if (sizeof($argv) == 3) {
		$transaction = $datastore->transaction();
		$key = $datastore->key('SKU', $argv[1]);
		$product = $datastore->entity( $key, [
			'name' => strtolower($argv[2])
		]);
		$datastore->upsert($product);
		$transaction->commit();
	}
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
