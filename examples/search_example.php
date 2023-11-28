<?php

use xmlworld\apiclient\Requests\Properties;
use xmlworld\apiclient\Requests\RoomRequest;
use xmlworld\apiclient\Requests\RoomRequests;
use xmlworld\apiclient\Requests\SearchDetails;
use xmlworld\apiclient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$env = XMLClient::ENV_DEV;

$xmlClient = new XMLClient(login: $login, password: $password, env: $env);

$searchDetails = new SearchDetails(
	arrivalDate: '2023-09-01',	// arrival date
	duration: 5,				// duration in days
	roomRequests: new RoomRequests(		// list of rooms
		RoomRequest::fromAges(2),
		RoomRequest::fromAges(
			1,		// number of adults
			16,		// age of first child (variadic)
			8,			// age of second child
			2			// age of third child
		),
	),
	properties: new Properties(19, 21),	// list of properties if searching for some
	propertyID: null,								// if only one we can use this param, but they exclude each other
	mealBasisID: 0,									// meal basis
	minStarRating: 0,								// filter by star rating
	minimumPrice: 0,								// filter by minimum price
	maximumPrice: 0									// filter by max price
);

try {
	echo 'before' . PHP_EOL;
	$result = $xmlClient->search(searchDetails: $searchDetails);

	print_r($result);
} catch (Throwable $e) {
	echo '[' . $e->getMessage() . ']';
}

exit('Done');
