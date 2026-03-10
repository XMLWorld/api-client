<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends BaseSerializeXML
{
	use RoomBookingsTrait;

	#[Test]
    public function roomBookingOneAdultOnly() : array
    {
		list($instance, , ) = $details = $this->getRoomBookingOneAdultOnly();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function roomBookingTwoAdults() : array
    {
		list($instance, , ) = $details = $this->getRoomBookingTwoAdults();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function roomBookingAdultAndChild() : array
    {
		list($instance, , ) = $details = $this->getRoomBookingAdultAndChild();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('roomBookingOneAdultOnly')]
    public function oneRoomBookings(array $roomBooking) : array
    {
		list($roomBookingInstance, , ) = $roomBooking;
		list($instance, , ) = $details = $this->getOneRoomBookings($roomBooking);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('roomBookingOneAdultOnly')]
	#[Depends('roomBookingTwoAdults')]
    public function twoRoomBookings(array $roomBooking1, array $roomBooking2) : array
    {
		list($roomBooking1Instance, , ) = $roomBooking1;
		list($roomBooking2Instance, , ) = $roomBooking2;
		list($instance, , ) = $details = $this->getTwoRoomBookings($roomBooking1, $roomBooking2);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}