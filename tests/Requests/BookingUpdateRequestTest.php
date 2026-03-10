<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookingUpdateRequestTest extends BaseSerializeXML
{
	use BookingUpdateRequestTrait;

	#[Test]
    public function bookingUpdateRequest() : array
    {
		list($instance, , ) = $details = $this->getBookingUpdateRequest();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}