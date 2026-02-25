<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Test\Common\GuestsTrait;

trait RoomBookingsTrait
{
	use GuestsTrait;

    protected function getRoomBookingOneAdultOnly()
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

    protected function getRoomBookingTwoAdults()
    {
		list($oneGuestsInstance, $oneGuestsSerialize, $oneGuestsUnserialize) = $this->getOneGuests();

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

    protected function getRoomBookingAdultAndChild()
    {
		list($instance, $serialize, $unserialize) = $this->getTwoGuests();


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

    protected function getOneRoomBookings()
    {
		list($instance, $serialize, $unserialize) = $this->getRoomBookingAdultAndChild();

        $instance = new RoomBookings(
			$instance
        );

		$serialize = <<<XML
<RoomBookings>
	$serialize
</RoomBookings>
XML;

		$unserialize = <<<XML
<RoomBookings>
	$unserialize
</RoomBookings>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoRoomBookings()
    {
		list($roomBookingTwoAdultInstance, 		$roomBookingTwoAdultSerialize, 		$roomBookingTwoAdultUnserialize) 		= $this->getRoomBookingTwoAdults();
		list($roomBookingAdultAndChildInstance, $roomBookingAdultAndChildSerialize, $roomBookingAdultAndChildUnserialize)	= $this->getRoomBookingAdultAndChild();

		$instance = new RoomBookings(
			$roomBookingTwoAdultInstance,
			$roomBookingAdultAndChildInstance
        );

		$serialize = <<<XML
<RoomBookings>
	$roomBookingTwoAdultSerialize
	$roomBookingAdultAndChildSerialize
</RoomBookings>
XML;

		$unserialize = <<<XML
<RoomBookings>
	$roomBookingTwoAdultUnserialize
	$roomBookingAdultAndChildUnserialize
</RoomBookings>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}