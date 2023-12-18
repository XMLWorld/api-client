<?php

namespace XMLWorld\ApiClient\Responses;

class BookResponse extends Response
{
	public function __construct(
		RequestInfo $requestInfo,
		ReturnStatus $returnStatus,
		public ?BookingDetails $bookingDetails = null
	){
		parent::__construct($requestInfo, $returnStatus);
	}
}
