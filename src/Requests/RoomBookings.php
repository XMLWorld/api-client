<?php

namespace xmlworld\apiclient\Requests;

use xmlworld\apiclient\Classes\CommonCollection;

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