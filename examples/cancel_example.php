<?php

use xmlworld\apiclient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$bookingReference = 'reference';
$cancellationReason = 'This is a test cancellation';
$env = XMLClient::ENV_DEV;

$xmlClient = new XMLClient(login: $login, password: $password, env: $env);

try {
	$result = $xmlClient->cancel(reference: $bookingReference, reason: $cancellationReason);

	print_r($result);
} catch (Throwable $e) {
}

