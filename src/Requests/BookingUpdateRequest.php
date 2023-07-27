<?php

namespace XmlWorld\ApiClient\Requests;

class BookingUpdateRequest extends BookingRequest
{
    public function __construct(
    	LoginDetails $loginDetails,
		string $bookingReference,
		public string $tradeReference,
		?bool $mock = null
	) {
        parent::__construct($loginDetails, $bookingReference, $mock);
    }
}
