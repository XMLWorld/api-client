<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Common\Guests;

class RoomBooking extends AbstractResponse
{
	public function __construct(
		public int $roomID,
		public string $name,
		public ?string $view = null,
		public int $mealBasisID,
		public int $adults,
		public int $children,
		public int $infants,
		public ?Guests $guests = null,
		public ?Supplements $supplements = null,
		public ?SpecialOffers $specialOffers = null,
		public ?Taxes $taxes = null,
		public ?CancellationPolicies $cancellationPolicies = null,
		public float $roomPrice
	){
		if(is_null($guests)){
			$this->guests = new Guests();
		}
	}
}