<?php

namespace XMLWorld\ApiClient\Responses;

class Tax extends AbstractResponse
{
	public function __construct(
		public string $taxName,
		public bool $inclusive,
		public float $total
	){}
}