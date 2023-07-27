<?php

use XmlWorld\ApiClient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$bookingReference = 'reference';
$tradeReference = 'trade reference';
$env = XMLClient::ENV_DEV;

$xmlClient = new XMLClient(login: $login, password: $password, env: $env);

try {
	$result = $xmlClient->bookingUpdate(reference: $bookingReference, tradeReference: $tradeReference);

	print_r($result);
} catch (Throwable $e) {
}

