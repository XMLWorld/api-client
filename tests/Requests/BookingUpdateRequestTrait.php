<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\BookingRequest;
use XMLWorld\ApiClient\Requests\BookingUpdateRequest;
use XMLWorld\ApiClient\Requests\BookRequest;

trait BookingUpdateRequestTrait
{
	use LoginDetailsTrait;

    protected function getBookingUpdateRequest() : array
    {
		list($loginDetailsInstance, 			$loginDetailsSerialize, 			$loginDetailsUnserialize) 			= $this->getLoginDetails();

        $instance = new BookingUpdateRequest(
			$loginDetailsInstance,
			'reference',
			'trade_reference',
			true
		);

		$serialize = <<<XML
<BookingUpdateRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	<BookingReference>reference</BookingReference>
	<TradeReference>trade_reference</TradeReference>
</BookingUpdateRequest>
XML;

		$unserialize = <<<XML
<BookingUpdateRequest>
<TradeReference>trade_reference</TradeReference>
	$loginDetailsUnserialize
	
	<BookingReference>reference</BookingReference>
	
	<Mock>True</Mock>
</BookingUpdateRequest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}