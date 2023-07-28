<?php

namespace xmlworld\apiclient\Requests;

use xmlworld\apiclient\Common\Guests;

class RoomBooking extends AbstractRequest
{
	public function __construct(
		public int $roomID,
		public int $mealBasisID,
		public int $adults,
		public int $children,
		public int $infants,
		public ?Guests $guests = null
	){
		if(is_null($guests)){
			$this->guests = new Guests();
		}
	}
}