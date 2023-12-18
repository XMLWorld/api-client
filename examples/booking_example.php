<?php

use XMLWorld\ApiClient\XMLClient;

$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'autoload.php']);
if(!file_exists($autoload)){
	$autoload = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);
}
require_once $autoload;

//XMLClient::setDevURL('your own dev url');

$login = 'login';
$password = 'pass';
$bookingReference = 'reference';
$env = XMLClient::ENV_DEV;

$xmlClient = new XMLClient(login: $login, password: $password, env: $env);

try {
	$result = $xmlClient->booking(reference: $bookingReference);

	print_r($result);
} catch (Throwable $e) {
	echo "[{$e->getMessage()}]";
}

exit('Done');

