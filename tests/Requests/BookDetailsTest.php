<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookDetailsTest extends BaseSerializeXML
{
	use BookDetailsTrait;

	#[Test]
    public function oneRoomBookingDetails() : array
    {
		list($instance, , ) = $details = $this->getOneRoomBookingDetails();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function twoRoomBookingDetails() : array
    {
		list($instance, , ) = $details = $this->getTwoRoomBookingDetails();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}