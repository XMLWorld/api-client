<?php


namespace XmlWorld\ApiClient\Responses;

class Erratum extends AbstractResponse
{
	public function __construct(
		public string $startDate,
		public string $endDate,
		public string $description
	){}
}