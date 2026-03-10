<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookingDetailsTest extends BaseSerializeXML
{
	use BookingDetailsTrait;

	#[Test]
    public function bookingDetails() : array
    {
		list($instance, , ) = $details = $this->getBookingDetails();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function cancelledBookingDetails() : array
	{
		list($instance, , ) = $details = $this->getCancelledBookingDetails();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}