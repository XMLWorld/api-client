<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends BaseSerializeXML
{
	use RoomBookingsTrait;

	#[Test]
    public function leadGuestOnlyBookResponse() : array
    {
		list($instance, , ) = $details = $this->getLeadGuestOnlyBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function leadGuestAndGuestBookResponse() : array
    {
		list($instance, , ) = $details = $this->getLeadGuestAndGuestBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function adultAndChildBookResponse() : array
    {
		list($instance, , ) = $details = $this->getAdultAndChildBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function noSupplementsEOTaxesCancellationsBookResponse() : array
    {
		list($instance, , ) = $details = $this->getNoSupplementsEOTaxesCancellationsBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('leadGuestOnlyBookResponse')]
    public function oneRoomBooking(array $leadGuestOnlyBookResponse) : array
    {
		list($instance, , ) = $details = $this->getOneRoomBooking($leadGuestOnlyBookResponse);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('leadGuestOnlyBookResponse')]
	#[Depends('leadGuestAndGuestBookResponse')]
    public function twoRoomBooking(array $leadGuestOnlyBookResponse, array $leadGuestAndGuestBookResponse) : array
    {
		list($instance, , ) = $details = $this->getTwoRoomBooking($leadGuestOnlyBookResponse, $leadGuestAndGuestBookResponse);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}