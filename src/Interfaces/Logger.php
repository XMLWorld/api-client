<?php

namespace XmlWorld\ApiClient\Interfaces;

interface Logger
{
	public function logRequest(string $log) : void;

	public function logResponse(int $statusCode, string $log) : void;
}