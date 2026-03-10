<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\BookingRequest;
use XMLWorld\ApiClient\Requests\BookRequest;
use XMLWorld\ApiClient\Requests\CancelRequest;

trait CancelRequestTrait
{
	use LoginDetailsTrait;

    protected function getCancellationRequest() : array
    {
		list($loginDetailsInstance, 			$loginDetailsSerialize, 			$loginDetailsUnserialize) 			= $this->getLoginDetails();

        $instance = new CancelRequest(
			$loginDetailsInstance,
			'reference',
			'This is a test cancellation',
			true
		);

		$serialize = <<<XML
<CancelRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	<BookingReference>reference</BookingReference>
	<Reason>This is a test cancellation</Reason>
</CancelRequest>
XML;

		$unserialize = <<<XML
<CancelRequest>
	$loginDetailsUnserialize
	<BookingReference>reference</BookingReference>
	<Reason>This is a test cancellation</Reason><Mock>True</Mock>
</CancelRequest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}