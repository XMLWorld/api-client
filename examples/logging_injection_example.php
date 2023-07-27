<?php

use XmlWorld\ApiClient\Interfaces\Logger;
use XmlWorld\ApiClient\Requests\Properties;
use XmlWorld\ApiClient\Requests\RoomRequest;
use XmlWorld\ApiClient\Requests\RoomRequests;
use XmlWorld\ApiClient\Requests\SearchDetails;
use XmlWorld\ApiClient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$env = XMLClient::ENV_DEV;

//you can implement the Logger interface to inject your logging implementation in the client.
$logging = new class implements Logger {
	public function logRequest(string $log): void
	{
		// TODO: Implement logRequest() method.
	}

	public function logResponse(int $statusCode, string $log): void
	{
		// TODO: Implement logResponse() method.
	}
};

$xmlClient = new XMLClient(login: $login, password: $password, env: $env, logger: $logging);

$searchDetails = new SearchDetails(
	arrivalDate: '2023-09-01',
	duration: 5,
	regionID: 0,
	roomRequests: new RoomRequests(
		RoomRequest::fromAges(2)
	),
	properties: new Properties(19, 21),
	propertyID: null,
	mealBasisID: 0,
	minStarRating: 0,
	minimumPrice: 0,
	maximumPrice: 0
);

try {
	$result = $xmlClient->search(searchDetails: $searchDetails);

	print_r($result);
} catch (Throwable $e) {
}
