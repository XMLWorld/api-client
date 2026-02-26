<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Test\Common\GuestsTrait;

trait RoomBookingsTrait
{
	use GuestsTrait;

    protected function getRoomBookingOneAdultOnly() : array
    {
        $instance = new RoomBooking(
            155558,
            1,
            1,
            0,
            0
        );              //the adult is the Leadguest so no adults here

		$serialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests/>
</RoomBooking>
XML;

		$unserialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	
	<Infants>0</Infants> <Children>0</Children>
	<Guests/>
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getRoomBookingTwoAdults() : array
    {
		list($oneGuestsInstance, $oneGuestsSerialize, $oneGuestsUnserialize) = $this->getOneGuests($this->getGuest1());

        $instance = new RoomBooking(
            155558,
            1,
            2,
            0,
            0,
			$oneGuestsInstance
        );

		$serialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestsSerialize
</RoomBooking>
XML;

		$unserialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestsUnserialize
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getRoomBookingAdultAndChild() : array
    {
		list($instance, $serialize, $unserialize) = $this->getTwoGuests($this->getGuest1(), $this->getGuest2());

        $instance = new RoomBooking(
            155448,
            1,
            1,
            1,
            0,
			$instance
        );

		$serialize = <<<XML
<RoomBooking>
	<RoomID>155448</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	$serialize
</RoomBooking>
XML;

		$unserialize = <<<XML
<RoomBooking>
	<RoomID>155448</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	$unserialize
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getOneRoomBookings(array $roomBooking) : array
    {
		list($roomBookingInstance, $roomBookingSerialize, $roomBookingUnserialize) = $roomBooking;

        $instance = new RoomBookings(
			$roomBookingInstance
        );

		$serialize = <<<XML
<RoomBookings>
	$roomBookingSerialize
</RoomBookings>
XML;

		$unserialize = <<<XML
<RoomBookings>
	$roomBookingUnserialize
</RoomBookings>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoRoomBookings(array $roomBooking1, array $roomBooking2) : array
    {
		list($roomBooking1Instance, 		$roomBooking1Serialize, 		$roomBooking1Unserialize) 		= $roomBooking1;
		list($roomBooking2Instance, 		$roomBooking2Serialize, 		$roomBooking2Unserialize) 		= $roomBooking2;

		$instance = new RoomBookings(
			$roomBooking1Instance,
			$roomBooking2Instance
        );

		$serialize = <<<XML
<RoomBookings>
	$roomBooking1Serialize
	$roomBooking2Serialize
</RoomBookings>
XML;

		$unserialize = <<<XML
<RoomBookings>
	$roomBooking1Unserialize
	$roomBooking2Unserialize
</RoomBookings>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}