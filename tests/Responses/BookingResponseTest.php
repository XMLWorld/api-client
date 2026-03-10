<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookingResponseTest extends BaseSerializeXML
{
	use BookingResponseTrait;

	#[Test]
    public function bookingResponse() : array
    {
		list($instance, , ) = $details = $this->getBookingResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function failedBookingResponse() : array
	{
		list($instance, , ) = $details = $this->getFailedBookingResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function bookingResponseAfterCancellation() : array
	{
		list($instance, , ) = $details = $this->getBookingResponseAfterCancellation();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}