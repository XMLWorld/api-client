<?php

namespace XmlWorld\ApiClient\Responses;

class Supplement extends AbstractResponse
{
	public function __construct(
		public string $name,
		public string $duration,
		public string $multiplier,
		public float $total,
		public ?string $paxType = null
	){}
}