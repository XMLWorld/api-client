<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\BookingDetails;
use XMLWorld\ApiClient\Test\Common\LeadGuestsTrait;

trait BookingDetailsTrait
{
	use LeadGuestsTrait;
	use RoomBookingsTrait;
	use PropertiesTrait;

    protected function getBookingDetails()
    {
		list($leadGuestInstance, 		$leadGuestSerialize,		$leadGuestUnserialize)			= $this->getSimpleLeadGuest();
		list($twoRoomBookingInstance, 	$twoRoomBookingSerialize,	$twoRoomBookingUnserialize)		= $this->getTwoRoomBooking($this->getLeadGuestAndGuestBookResponse(), $this->getAdultAndChildBookResponse());
		list($complexPropertyInstance,	$complexPropertySerialize,	$complexPropertyUnserialize)	= $this->getComplexProperty();

		$instance = new BookingDetails(
            'HCF0011',
            '8430154',
            'Live',
            null,
            'EUR',
            null,
            '2023-11-01',
            5,
            $leadGuestInstance,
            null, //busyrooms have this
            'TEST_REF',
            1040,
            '2023-10-02',
			$twoRoomBookingInstance,
			$complexPropertyInstance
        );

		$serialize = <<<XML
<BookingDetails>
	<BookingReference>HCF0011</BookingReference>
	<SupplierReference>8430154</SupplierReference>
	<Status>Live</Status>
	<Currency>EUR</Currency>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	$leadGuestSerialize
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<DueDate>2023-10-02</DueDate>
	$twoRoomBookingSerialize
	$complexPropertySerialize
</BookingDetails>
XML;

		$unserialize = <<<XML
<BookingDetails>
	<BookingReference>HCF0011</BookingReference>
	<SupplierReference>8430154</SupplierReference>
	<Status>Live</Status>
	<ArrivalDate>2023-11-01</ArrivalDate>
	<Duration>5</Duration>
	$leadGuestUnserialize
	<Request/>
	<TradeReference>TEST_REF</TradeReference>
	<TotalPrice>1040</TotalPrice>
	<Currency>EUR</Currency>
	<DueDate>2023-10-02</DueDate>
	$twoRoomBookingUnserialize
	$complexPropertyUnserialize
</BookingDetails>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getCancelledBookingDetails()
	{
		$instance = new BookingDetails(
			'HCL0011',
			'2DE9D13',
			'Cancelled',
			'This is a test cancellation',
			'EUR',
			0.0
		);

		$serialize = <<<XML
<BookingDetails>
	<BookingReference>HCL0011</BookingReference>
	<SupplierReference>2DE9D13</SupplierReference>
	<Status>Cancelled</Status>
	<CancellationReason>This is a test cancellation</CancellationReason>
	<Currency>EUR</Currency>
	<Amount>0</Amount>
</BookingDetails>
XML;

		$unserialize = <<<XML
<BookingDetails>
	<BookingReference>HCL0011</BookingReference>
	<SupplierReference>2DE9D13</SupplierReference>	<Status>Cancelled</Status>
	<CancellationReason>This is a test cancellation</CancellationReason>
	
	<Amount>0</Amount>	<Currency>EUR</Currency>
</BookingDetails>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}
