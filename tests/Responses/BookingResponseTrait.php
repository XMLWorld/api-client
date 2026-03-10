<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\BookingResponse;

trait BookingResponseTrait
{
	use ResponseTrait;
	use BookingDetailsTrait;

    protected function getBookingResponse()
    {
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusTrue();
		list($bookingDetailsInstance, 		$bookingDetailsSerialize,	$bookingDetailsUnserialize)			= $this->getBookingDetails();

		$instance = new BookingResponse(
			$responseInfoInstance,
			$returnStatusInstance,
			$bookingDetailsInstance
		);

		$serialize = <<<XML
<BookingResponse>
	$responseInfoSerialize
	$returnStatusSerialize
	$bookingDetailsSerialize
</BookingResponse>
XML;

		$unserialize = <<<XML
<BookingResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
	$bookingDetailsUnserialize
</BookingResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getFailedBookingResponse()
	{
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusFalse();

		$instance = new BookingResponse(
			$responseInfoInstance,
			$returnStatusInstance
		);

		$serialize = <<<XML
<BookingResponse>
	$responseInfoSerialize
	$returnStatusSerialize
</BookingResponse>
XML;

		$unserialize = <<<XML
<BookingResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
</BookingResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getBookingResponseAfterCancellation()
	{
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusTrue();
		list($cancelledBookingInstance,		$cancelledBookingSerialize,	$cancelledBookingUnserialize)		= $this->getCancelledBookingDetails();

		$instance = new BookingResponse(
			$responseInfoInstance,
			$returnStatusInstance,
			$cancelledBookingInstance
		);

		$serialize = <<<XML
<BookingResponse>
	$responseInfoSerialize
	$returnStatusSerialize
	$cancelledBookingSerialize
</BookingResponse>
XML;

		$unserialize = <<<XML
<BookingResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	$cancelledBookingUnserialize
</BookingResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}
