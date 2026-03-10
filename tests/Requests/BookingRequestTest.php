<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookingRequestTest extends BaseSerializeXML
{
	use BookingRequestTrait;

	#[Test]
    public function bookingRequest() : array
    {
		list($instance, , ) = $details = $this->getBookingRequest();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}