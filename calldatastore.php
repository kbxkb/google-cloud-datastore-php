<?php
require 'vendor/autoload.php';
use Google\Auth\ApplicationDefaultCredentials;
use Google\Cloud\Datastore\DatastoreClient;

try
{
	$mem = new Memcached();
	$mem->addServer("127.0.0.1", 11211);

	$projectId = 'triple-cab-162115';
	$datastore = new DatastoreClient([
	    'projectId' => $projectId
	]);

	echo 'Matches:<br/>';
	$matches_string = "";

	//Get the string typed in by user for autocompletion...
	$queryval = strtolower($_GET['searchtext']);

	//If it is not blank...
	if ($queryval[0]) {

		//we first have to check our local cache if we have the results for this query...
		$cache_hit = $mem->get($queryval);
		if ($cache_hit) {

			//yes! we have it it cache, no need to go back to datastore...
			$matches_string = (string) $cache_hit;
		} else {

			//cache miss, let us go to datastore and fetch the result...
			$upperlimit = $queryval . json_decode('"\ufffd"');
			$query = $datastore->query()
				->kind('SKU')
				->filter('name', '>=', $queryval)
				->filter('name', '<', $upperlimit)
				->order('name');
			$result = $datastore->runQuery($query);
			foreach ($result as $SKU) {
				$matches_string = $matches_string . $SKU['name'] . "<br/>";
			}

			//finally, let us insert this query result in our local cache so that next time,
			//we do not have to make a round-trip to datastore - note that we are caching for 7 days
			$mem->set($queryval, $matches_string, 604800);
		}
		echo $matches_string;
	}
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
