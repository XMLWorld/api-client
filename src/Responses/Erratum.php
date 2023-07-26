<?php


namespace XmlWorld\ApiPackagePhp\Responses;

class Erratum extends AbstractResponse
{
	public function __construct(
		public string $startDate,
		public string $endDate,
		public string $description
	){}
}