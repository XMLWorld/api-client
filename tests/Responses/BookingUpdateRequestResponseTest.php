<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookingUpdateRequestResponseTest extends BaseSerializeXML
{
	use BookingUpdateRequestResponseTrait;

	#[Test]
    public function bookingUpdateRequestResponse() : array
    {
		list($instance, , ) = $details = $this->getBookingUpdateRequestResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function failedBookingUpdateRequestResponse() : array
	{
		list($instance, , ) = $details = $this->getFailedBookingUpdateRequestResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}