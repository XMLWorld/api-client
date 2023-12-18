<?php

namespace XMLWorld\ApiClient;

class NullLogger implements Interfaces\Logger
{
	public function logRequest(string $log) : void
	{
		// do nothing
	}

	public function logResponse(int $statusCode, string $log) : void
	{
		// do nothing
	}
}