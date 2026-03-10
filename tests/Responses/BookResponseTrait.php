<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\BookingDetails;
use XMLWorld\ApiClient\Responses\BookResponse;
use XMLWorld\ApiClient\Responses\Property;
use XMLWorld\ApiClient\Test\Common\LeadGuestsTrait;

trait BookResponseTrait
{
	use ResponseTrait;
	use BookingDetailsTrait;

    protected function getBookResponse()
    {
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusTrue();
		list($bookingDetailsInstance, 		$bookingDetailsSerialize,	$bookingDetailsUnserialize)			= $this->getBookingDetails();

		$instance = new BookResponse(
			$responseInfoInstance,
			$returnStatusInstance,
			$bookingDetailsInstance
		);

		$serialize = <<<XML
<BookResponse>
	$responseInfoSerialize
	$returnStatusSerialize
	$bookingDetailsSerialize
</BookResponse>
XML;

		$unserialize = <<<XML
<BookResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
	$bookingDetailsUnserialize
</BookResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getFailedBookResponse()
	{
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getPriceDoesNotMatchStatus();

		$instance = new BookResponse(
			$responseInfoInstance,
			$returnStatusInstance
		);

		$serialize = <<<XML
<BookResponse>
	$responseInfoSerialize
	$returnStatusSerialize
</BookResponse>
XML;

		$unserialize = <<<XML
<BookResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
</BookResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}
