<?php

use XMLWorld\ApiClient\Interfaces\Logger;
use XMLWorld\ApiClient\Requests\Properties;
use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$env = XMLClient::ENV_DEV;

$myLogger = function($payload){
	echo $payload;
};

//you can implement the Logger interface to inject your logging implementation in the client.
$logging = new class($myLogger) implements Logger
{
	protected Closure $myLogger;
	public function __construct(Closure $myLogger)
	{
		$this->myLogger = $myLogger;
	}

	public function logRequest(string $log): void
	{
		($this->myLogger)($log);
	}

	public function logResponse(int $statusCode, string $log): void
	{
		($this->myLogger)($log);
	}
};

$xmlClient = new XMLClient(login: $login, password: $password, env: $env, logger: $logging);

$searchDetails = new SearchDetails(
	arrivalDate: '2023-09-01',
	duration: 5,
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
