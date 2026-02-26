<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Supplier;

trait SupplierTrait
{
	protected function getRMISupplier() : array
	{
		$instance = new Supplier(
			6,
			'RMI'
		);

		$serialize = <<<'XML'
<Supplier>
	<SupplierID>6</SupplierID>
	<SupplierName>RMI</SupplierName>
</Supplier>
XML;

		$unserialize = <<<'XML'
<Supplier>
	<SupplierID>6</SupplierID>
			<SupplierName>RMI</SupplierName>
</Supplier>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getBusyRoomsSupplier() : array
	{
		$instance = new Supplier(
			11,
			'BusyRooms'
		);

		$serialize = <<<'XML'
<Supplier>
	<SupplierID>11</SupplierID>
	<SupplierName>BusyRooms</SupplierName>
</Supplier>
XML;

		$unserialize = <<<'XML'
<Supplier>
	<SupplierID>11</SupplierID>
			<SupplierName>BusyRooms</SupplierName>
</Supplier>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}