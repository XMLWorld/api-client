<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends BaseSerializeXML
{
	use RoomBookingsTrait;

    public function testLeadGuestOnlyBookResponse()
    {
		$details = $this->getLeadGuestOnlyBookResponse();

		$this->doTest(...$details);

		return $details;
    }

    public function testLeadGuestAndGuestBookResponse()
    {
		$details = $this->getLeadGuestAndGuestBookResponse();

		$this->doTest(...$details);

		return $details;
    }

    public function testAdultAndChildBookResponse()
    {
		$details = $this->getAdultAndChildBookResponse();

		$this->doTest(...$details);

		return $details;
    }

    public function testNoSupplementsEOTaxesCancellationsBookResponse()
    {
		$details = $this->getNoSupplementsEOTaxesCancellationsBookResponse();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneRoomBooking()
    {
		$details = $this->getOneRoomBooking();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoRoomBooking()
    {
		$details = $this->getTwoRoomBooking();

		$this->doTest(...$details);

		return $details;
    }
}