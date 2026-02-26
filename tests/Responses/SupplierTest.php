<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SupplierTest extends BaseSerializeXML
{
	use SupplierTrait;

	#[Test]
	public function rMISupplier() : array
	{
		list($instance, , ) = $details = $this->getRMISupplier();

		$this->assertSame(6, $instance->supplierID);
		$this->assertSame('RMI', $instance->supplierName);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function busyRoomsSupplier() : array
	{
		list($instance, , ) = $details = $this->getBusyRoomsSupplier();

		$this->assertSame(11, $instance->supplierID);
		$this->assertSame('BusyRooms', $instance->supplierName);

		$this->doTest(...$details);

		return $details;
	}
}