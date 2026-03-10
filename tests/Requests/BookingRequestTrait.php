<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\BookingRequest;
use XMLWorld\ApiClient\Requests\BookRequest;

trait BookingRequestTrait
{
	use LoginDetailsTrait;

    protected function getBookingRequest() : array
    {
		list($loginDetailsInstance, 			$loginDetailsSerialize, 			$loginDetailsUnserialize) 			= $this->getLoginDetails();

        $instance = new BookingRequest(
			$loginDetailsInstance,
			'reference',
			true
		);

		$serialize = <<<XML
<BookingRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	<BookingReference>reference</BookingReference>
</BookingRequest>
XML;

		$unserialize = <<<XML
<BookingRequest>
	$loginDetailsUnserialize
	<Mock>True</Mock>
	<BookingReference>reference</BookingReference>
</BookingRequest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}