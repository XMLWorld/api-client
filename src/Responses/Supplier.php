<?php

namespace XmlWorld\ApiClient\Responses;

class Supplier extends AbstractResponse
{
	public function __construct(
		public int $supplierID,
		public string $supplierName
	) {}
}