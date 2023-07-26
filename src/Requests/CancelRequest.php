<?php


namespace XmlWorld\ApiPackagePhp\Requests;

class CancelRequest extends BookingRequest
{
    public function __construct(
    	LoginDetails $loginDetails,
		string $bookingReference,
		public string $reason,
		?bool $mock = null
	) {
        parent::__construct($loginDetails, $bookingReference, $mock);
    }
}
