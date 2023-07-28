<?php

use xmlworld\apiclient\Common\Guest;
use xmlworld\apiclient\Common\Guests;
use xmlworld\apiclient\Common\LeadGuest;
use xmlworld\apiclient\Requests\BookDetails;
use xmlworld\apiclient\Requests\RoomBooking;
use xmlworld\apiclient\Requests\RoomBookings;
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

$bookingDetails = new BookDetails(
	arrivalDate: '2023-11-01',
	duration: 5,
	tradeReference: 'TEST_REF',
	totalPrice: 1040,
	leadGuest: new LeadGuest(
		firstName: 'TestLeadFName',
		lastName: 'TestLeadLName',
		title: 'Mr'
	),
	roomBookings: new RoomBookings(
		new RoomBooking(
			roomID: 20011,
			mealBasisID: 6,
			adults: 2,
			children: 0,
			infants: 0,
			guests: new Guests(
				new Guest(
					type: 'Adult',
					firstName: 'TestGuestFName',
					lastName: 'TestGuestLName',
					title: 'Mrs',
					age: null,
					nationality: 'French'
				)
			)
		),
	)
);

try {
	$result = $xmlClient->book(bookingDetails: $bookingDetails);

	print_r($result);
} catch (Throwable $e) {
}

