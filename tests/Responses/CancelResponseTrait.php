<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\CancelResponse;

trait CancelResponseTrait
{
	use ResponseTrait;
	use BookingDetailsTrait;

    protected function getCancelResponse()
    {
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusTrue();
		list($bookingDetailsInstance, 		$bookingDetailsSerialize,	$bookingDetailsUnserialize)			= $this->getCancelledBookingDetails();

		$instance = new CancelResponse(
			$responseInfoInstance,
			$returnStatusInstance,
			$bookingDetailsInstance
		);

		$serialize = <<<XML
<CancelResponse>
	$responseInfoSerialize
	$returnStatusSerialize
	$bookingDetailsSerialize
</CancelResponse>
XML;

		$unserialize = <<<XML
<CancelResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
	$bookingDetailsUnserialize
</CancelResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getFailedCancelResponse()
	{
		list($responseInfoInstance, 		$responseInfoSerialize,		$responseInfoUnserialize)			= $this->getResponseInfo();
		list($returnStatusInstance, 		$returnStatusSerialize,		$returnStatusUnserialize)			= $this->getReturnStatusFalse();

		$instance = new CancelResponse(
			$responseInfoInstance,
			$returnStatusInstance
		);

		$serialize = <<<XML
<CancelResponse>
	$responseInfoSerialize
	$returnStatusSerialize
</CancelResponse>
XML;

		$unserialize = <<<XML
<CancelResponse>
$returnStatusUnserialize
	$responseInfoUnserialize
	
</CancelResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}
