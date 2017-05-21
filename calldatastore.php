<?php

require 'vendor/autoload.php';
use Google\Auth\ApplicationDefaultCredentials;
//use GuzzleHttp\Client;
//use GuzzleHttp\HandlerStack;
use Google\Cloud\Datastore\DatastoreClient;

try
{
//==============================================================================================
/*
// specify the path to your application credentials
putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/kbxkb/cp100-bbde4d919e35.json');

// define the scopes for your API call
$scopes = ['https://www.googleapis.com/auth/drive.readonly'];

// create middleware
$middleware = ApplicationDefaultCredentials::getMiddleware($scopes);
$stack = HandlerStack::create();
$stack->push($middleware);

// create the HTTP client
$client = new Client([
  'handler' => $stack,
  'base_uri' => 'https://www.googleapis.com',
  'auth' => 'google_auth'  // authorize all requests
]);

// make the request
$response = $client->get('drive/v2/files');

// show the result!
print_r((string) $response->getBody());
*/
//=============================================================================================

$projectId = 'triple-cab-162115';
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);


date_default_timezone_set('UTC');
$timenow = date('l jS \of F Y h:i:s A');
$queryval = $_GET['searchtext'] . ' ' . $timenow;
echo $queryval;


















} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>
