<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SupplierTest extends BaseSerializeXML
{
	use SupplierTrait;

	public function testRMISupplier()
	{
		$details = $this->getRMISupplier();

		$this->doTest(...$details);

		return $details;
	}

	public function testSBusyRoomsSupplier()
	{
		$details = $this->getBusyRoomsSupplier();

		$this->doTest(...$details);

		return $details;
	}
}