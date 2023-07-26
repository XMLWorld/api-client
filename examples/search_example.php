<?php

use XmlWorld\ApiPackagePhp\Requests\Properties;
use XmlWorld\ApiPackagePhp\Requests\RoomRequest;
use XmlWorld\ApiPackagePhp\Requests\RoomRequests;
use XmlWorld\ApiPackagePhp\Requests\SearchDetails;
use XmlWorld\ApiPackagePhp\XMLClient;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../../autoload.php';

$xmlClient = new XMLClient('login', 'pass');

$searchDetails = new SearchDetails(
	'2023-11-01',
	5,
	0,
	new RoomRequests(
		RoomRequest::fromAges(2)
	),
	new Properties(70011),
	null,
	0,
	0,
	0,
	0
);

try {
	$result = $xmlClient->search($searchDetails);

	print_r($result);
} catch (Throwable $e) {
}
