<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends BaseSerializeXML
{
	use RoomBookingsTrait;

    public function testRoomBookingOneAdultOnly()
    {
		$details = $this->getRoomBookingOneAdultOnly();

		$this->doTest(...$details);

		return $details;
    }

    public function testRoomBookingTwoAdults()
    {
		$details = $this->getRoomBookingTwoAdults();

		$this->doTest(...$details);

		return $details;
    }

    public function testRoomBookingAdultAndChild()
    {
		$details = $this->getRoomBookingAdultAndChild();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneRoomBookings()
    {
		$details = $this->getOneRoomBookings();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoRoomBookings()
    {
		$details = $this->getTwoRoomBookings();

		$this->doTest(...$details);

		return $details;
    }
}