<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use XMLWorld\ApiClient\Common\LeadGuest;
use XMLWorld\ApiClient\Requests\BookDetails;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Test\Common\LeadGuestsTrait;

trait BookDetailsTrait
{
	use RoomBookingsTrait;

    public function getOneRoomBookingDetails()
    {
		list($instance, $serialize, $unserialize) = $this->getRoomBookingTwoAdults();

		$simpleLeadGuestBook = new LeadGuest(
			'Jim',
			'Watsworth',
			'Mr'
		);

        $instance = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
            $simpleLeadGuestBook,
            null,
            new RoomBookings($instance)
        );

		$serialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<LeadGuest>
		<FirstName>Jim</FirstName>
		<LastName>Watsworth</LastName>
		<Title>Mr</Title>
	</LeadGuest>
	<RoomBookings>
		$serialize
	</RoomBookings>
</BookDetails>
XML;

		$unserialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<LeadGuest>
		<FirstName>Jim</FirstName>
		<LastName>Watsworth</LastName>
		<Title>Mr</Title>
	</LeadGuest>
	<RoomBookings>
		$unserialize
	</RoomBookings>
</BookDetails>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	#[Depends('testTwoRoomBookings')]
    public function testTwoRoomBookingDetails($twoRoomBookings)
    {
		list($twoRoomBookingsInstance, $twoRoomBookingsSerialize, $twoRoomBookingsUnserialize) = $twoRoomBookings;

        $simpleLeadGuestBook = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr'
        );

        $instance = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
            $simpleLeadGuestBook,
            null,
			$twoRoomBookingsInstance
        );

		$serialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<LeadGuest>
		<FirstName>Jim</FirstName>
		<LastName>Watsworth</LastName>
		<Title>Mr</Title>
	</LeadGuest>
	$twoRoomBookingsSerialize
</BookDetails>
XML;

		$unserialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<LeadGuest>
		<FirstName>Jim</FirstName>
		<LastName>Watsworth</LastName>
		<Title>Mr</Title>
	</LeadGuest>
	$twoRoomBookingsUnserialize
</BookDetails>
XML;

		$twoRoomBookingDetails = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$twoRoomBookingDetails);


        return $twoRoomBookingDetails;
    }

}