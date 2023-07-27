<?php

namespace XmlWorld\ApiClient\Requests;

use XmlWorld\ApiClient\Classes\CommonCollection;

/**
 * @extends CommonCollection<RoomBooking>
 */
class RoomBookings extends CommonCollection
{
	public function __construct(
		RoomBooking ...$roomBooking
	) {
		$this->data = $roomBooking;
	}
}