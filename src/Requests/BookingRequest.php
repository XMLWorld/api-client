<?php


namespace XmlWorld\ApiPackagePhp\Requests;

class BookingRequest extends Request
{
    public function __construct(
    	LoginDetails $loginDetails,
		public string $bookingReference,
		?bool $mock = null
	) {
        parent::__construct($loginDetails, $mock);
    }
}
