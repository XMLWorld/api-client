<?php

namespace XMLWorld\ApiClient\Common;

class Guest extends AbstractCommon
{
	public function __construct(
		public string $type,
		public string $firstName,
		public string $lastName,
		public ?string $title = null,
		public ?int $age = null,
		public ?string $nationality = null
	){}
}