<?php

namespace XMLWorld\ApiClient\Requests;

use XMLWorld\ApiClient\Common\LeadGuest;

class BookDetails extends AbstractRequest
{
	public function __construct(
		public string $arrivalDate,
		public int $duration,
		public string $tradeReference,
		public ?float $totalPrice,
		public LeadGuest $leadGuest,
        public ?string $request,     //Comment
		public RoomBookings $roomBookings,
	){}
}