<?php

use XmlWorld\ApiPackagePhp\XMLClient;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../../autoload.php';

$xmlClient = new XMLClient('login', 'pass');

try {
	$result = $xmlClient->bookingUpdate('reference', 'trade reference');

	print_r($result);
} catch (Throwable $e) {
}

