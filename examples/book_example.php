<?php

use XmlWorld\ApiPackagePhp\Common\Guest;
use XmlWorld\ApiPackagePhp\Common\Guests;
use XmlWorld\ApiPackagePhp\Common\LeadGuest;
use XmlWorld\ApiPackagePhp\Requests\BookDetails;
use XmlWorld\ApiPackagePhp\Requests\RoomBooking;
use XmlWorld\ApiPackagePhp\Requests\RoomBookings;
use XmlWorld\ApiPackagePhp\XMLClient;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../../autoload.php';

$xmlClient = new XMLClient('login', 'pass');

$bookingDetails = new BookDetails(
	'2023-11-01',
	5,
	'TEST_REF',
	1040,
	new LeadGuest(
		'TestLeadFName',
		'TestLeadLName',
		'Mr'
	),
	new RoomBookings(
		new RoomBooking(
			20011,
			6,
			2,
			0,
			0,
			new Guests(
				new Guest(
					'Adult',
					'TestGuestFName',
					'TestGuestLName',
					'Mrs',
					null,
					'French'
				)
			)
		),
	)
);

try {
	$result = $xmlClient->book($bookingDetails);

	print_r($result);
} catch (Throwable $e) {
}

