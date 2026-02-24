<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Requests\RoomBookings;

class RoomBookingsTest extends LoginDetailsTest
{
    public function testRoomBookingOneAdultOnly()
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
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests/>
</RoomBooking>
XML;


		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

        return $details;
    }

    public function testRoomBookingTwoAdults()
    {
        $oneGuest = new Guest(   //this is the second adult.
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

        $instance = new RoomBooking(
            155558,
            1,
            2,
            0,
            0,
            new Guests($oneGuest)
        );

		$serialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests>
		<Guest>
			<Type>Adult</Type>
			<FirstName>Sally</FirstName>
			<LastName>Smith</LastName>
			<Title>Mrs</Title>
			<Nationality>French</Nationality>
		</Guest>
	</Guests>
</RoomBooking>
XML;

		$unserialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests>
		<Guest>
			<Type>Adult</Type>
			<FirstName>Sally</FirstName>
			<LastName>Smith</LastName>
			<Title>Mrs</Title>
			<Nationality>French</Nationality>
		</Guest>
	</Guests>
</RoomBooking>
XML;

		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

        return $details;
    }

    public function testRoomBookingAdultAndChild()
    {
        $adultGuestBook = new Guest(
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

        $childGuestBook = new Guest(
            'Child',
            'Jimmy',
            'Smith',
            null,
            5,
            'French'
        );

        $instance = new RoomBooking(
            155448,
            1,
            1,
            1,
            0,
            new Guests(
                $adultGuestBook,
                $childGuestBook
            )
        );

		$serialize = <<<'XML'
<RoomBooking>
	<RoomID>155448</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	<Guests>
		<Guest>
			<Type>Adult</Type>
			<FirstName>Sally</FirstName>
			<LastName>Smith</LastName>
			<Title>Mrs</Title>
			<Nationality>French</Nationality>
		</Guest>
		<Guest>
			<Type>Child</Type>
			<FirstName>Jimmy</FirstName>
			<LastName>Smith</LastName>
			<Age>5</Age>
			<Nationality>French</Nationality>
		</Guest>
	</Guests>
</RoomBooking>
XML;

		$unserialize = <<<XML
<RoomBooking>
	<RoomID>155448</RoomID>
	<MealBasisID>1</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	<Guests>
		<Guest>
			<Type>Adult</Type>
			<FirstName>Sally</FirstName>
			<LastName>Smith</LastName>
			<Title>Mrs</Title>
			<Nationality>French</Nationality>
		</Guest>
		<Guest>
			<Type>Child</Type>
			<FirstName>Jimmy</FirstName>
			<LastName>Smith</LastName>
			<Age>5</Age>
			<Nationality>French</Nationality>
		</Guest>
	</Guests>
</RoomBooking>
XML;

		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

		return $details;
    }

	#[Depends('testRoomBookingAdultAndChild')]
    public function testOneRoomBookings($roomBookingAdultAndChild)
    {
		list($roomBookingAdultAndChildInstance, $roomBookingAdultAndChildSerialize, $roomBookingAdultAndChildUnserialize) = $roomBookingAdultAndChild;

        $instance = new RoomBookings(
			$roomBookingAdultAndChildInstance
        );

		$serialize = <<<XML
<RoomBookings>
	$roomBookingAdultAndChildSerialize
</RoomBookings>
XML;

		$unserialize = <<<XML
<RoomBookings>
	$roomBookingAdultAndChildUnserialize
</RoomBookings>
XML;

		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

		return $details;
    }

	#[Depends('testRoomBookingTwoAdults')]
	#[Depends('testRoomBookingAdultAndChild')]
    public function testTwoRoomBookings($roomBookingTwoAdult, $roomBookingAdultAndChild)
    {
		list($roomBookingTwoAdultInstance, 		$roomBookingTwoAdultSerialize, 		$roomBookingTwoAdultUnserialize) 		= $roomBookingTwoAdult;
		list($roomBookingAdultAndChildInstance, $roomBookingAdultAndChildSerialize, $roomBookingAdultAndChildUnserialize)	= $roomBookingAdultAndChild;

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
		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

		return $details;
    }
}