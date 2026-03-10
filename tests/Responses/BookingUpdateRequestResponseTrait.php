<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\BookingResponse;
use XMLWorld\ApiClient\Responses\BookingUpdateRequestResponse;

trait BookingUpdateRequestResponseTrait
{
	use ResponseTrait;
	use BookingDetailsTrait;

    protected function getBookingUpdateRequestResponse()
    {
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusTrue();
		list($bookingDetailsInstance, 		$bookingDetailsSerialize,	$bookingDetailsUnserialize)			= $this->getBookingDetails();

		$instance = new BookingUpdateRequestResponse(
			$responseInfoInstance,
			$returnStatusInstance,
			$bookingDetailsInstance
		);

		$serialize = <<<XML
<BookingUpdateRequestResponse>
	$responseInfoSerialize
	$returnStatusSerialize
	$bookingDetailsSerialize
</BookingUpdateRequestResponse>
XML;

		$unserialize = <<<XML
<BookingUpdateRequestResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
	$bookingDetailsUnserialize
</BookingUpdateRequestResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getFailedBookingUpdateRequestResponse()
	{
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getNoResponseFromSupplier();

		$instance = new BookingUpdateRequestResponse(
			$responseInfoInstance,
			$returnStatusInstance
		);

		$serialize = <<<XML
<BookingUpdateRequestResponse>
	$responseInfoSerialize
	$returnStatusSerialize
</BookingUpdateRequestResponse>
XML;

		$unserialize = <<<XML
<BookingUpdateRequestResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
</BookingUpdateRequestResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}
