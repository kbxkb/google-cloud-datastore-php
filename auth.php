<?php

require 'vendor/autoload.php';
use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

try
{
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

} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
