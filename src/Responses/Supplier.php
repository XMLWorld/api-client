<?php


namespace XmlWorld\ApiPackagePhp\Responses;


class Supplier extends AbstractResponse
{
	public function __construct(
		public int $supplierID,
		public string $supplierName
	) {}
}