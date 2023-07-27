<?php

namespace XmlWorld\ApiClient\Responses;

class CancellationPolicy extends AbstractResponse
{
	public function __construct(
		public string $cancelBy,
		public float $penalty,
	){}
}