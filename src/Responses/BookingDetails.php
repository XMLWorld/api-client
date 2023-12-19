<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Common\LeadGuest;
use XMLWorld\ApiClient\Requests\Request;

class BookingDetails extends AbstractResponse
{
	public function __construct(
		public string $bookingReference,
		public ?string $supplierReference, //This is optional
		public string $status,
		public ?string $cancellationReason = null,
		public string $currency,
		public ?float $amount = null,
		public ?string $arrivalDate = null,
		public ?int $duration = null,
		public ?LeadGuest $leadGuest = null,
		public ?string $request = null, //not sure what this is in Busy Rooms
		public ?string $tradeReference = null,
		public ?float $totalPrice = null,
		public ?string $dueDate = null,
		public ?RoomBookings $roomBookings = null,
		public ?Property $property = null,
	) {}
}