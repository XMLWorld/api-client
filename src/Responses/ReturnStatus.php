<?php

namespace XMLWorld\ApiClient\Responses;

class ReturnStatus extends AbstractResponse
{
	public function __construct(
		public bool $success,
		public ?string $exception = null
	) {}
}