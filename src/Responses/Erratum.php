<?php


namespace xmlworld\apiclient\Responses;

class Erratum extends AbstractResponse
{
	public function __construct(
		public string $startDate,
		public string $endDate,
		public string $description
	){}
}