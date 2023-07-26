<?php


namespace XmlWorld\ApiPackagePhp\Requests;

use XmlWorld\ApiPackagePhp\Common\LeadGuest;

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