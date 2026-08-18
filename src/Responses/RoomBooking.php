<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Common\Guests;

class RoomBooking extends AbstractResponse
{
	public function __construct(
		public int $roomID,
		public string $name,
		public ?string $view,
		public int $mealBasisID,
		public int $adults,
		public int $children,
		public int $infants,
		public ?Guests $guests,
		public ?Supplements $supplements,
		public ?SpecialOffers $specialOffers,
		public ?Taxes $taxes,
		public ?CancellationPolicies $cancellationPolicies,
		public float $roomPrice
	){
		if(is_null($guests)){
			$this->guests = new Guests();
		}
	}
}