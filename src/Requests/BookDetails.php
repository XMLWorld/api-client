<?php

namespace xmlworld\apiclient\Requests;

use xmlworld\apiclient\Common\LeadGuest;

class BookDetails extends AbstractRequest
{
	public function __construct(
		public string $arrivalDate,
		public int $duration,
		public string $tradeReference,
		public ?float $totalPrice = null,
		public LeadGuest $leadGuest,
		public RoomBookings $roomBookings,
	){}
}