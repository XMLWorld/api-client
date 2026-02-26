<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\BookDetails;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Test\Common\LeadGuestsTrait;

trait BookDetailsTrait
{
	use LeadGuestsTrait;
	use RoomBookingsTrait;

    protected function getOneRoomBookingDetails()
    {
		list($leadGuestInstance, $leadGuestSerialize, $leadGuestUnserialize) = $this->getAdultLeadGuest();
		list($instance, $serialize, $unserialize) = $this->getRoomBookingTwoAdults();

        $instance = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
			$leadGuestInstance,
            null,
            new RoomBookings($instance)
        );

		$serialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	$leadGuestSerialize
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
	$leadGuestUnserialize
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

    protected function getTwoRoomBookingDetails()
    {
		list($leadGuestInstance, $leadGuestSerialize, $leadGuestUnserialize) = $this->getAdultLeadGuest();
		list($twoRoomBookingsInstance, $twoRoomBookingsSerialize, $twoRoomBookingsUnserialize) = $this->getTwoRoomBookings();

        $instance = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
			$leadGuestInstance,
            null,
			$twoRoomBookingsInstance
        );

		$serialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	$leadGuestSerialize
	$twoRoomBookingsSerialize
</BookDetails>
XML;

		$unserialize = <<<XML
<BookDetails>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	$leadGuestUnserialize
	$twoRoomBookingsUnserialize
</BookDetails>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}