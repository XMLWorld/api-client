<?php


namespace XmlWorld\ApiPackagePhp\Responses;

class SpecialOffer extends AbstractResponse
{
	public function __construct(
		public string $name,
		public string $type,
		public ?float $value = null,
		public ?string $paxType = null,
		public ?float $total = null,
		public ?string $desc = null,
	){}
}