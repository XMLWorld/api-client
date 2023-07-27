<?php

namespace XmlWorld\ApiClient\Requests;

use XmlWorld\ApiClient\Common\LeadGuest;

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