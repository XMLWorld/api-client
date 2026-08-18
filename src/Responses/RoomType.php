<?php

namespace XMLWorld\ApiClient\Responses;

class RoomType extends AbstractResponse
{
	public function __construct(
		public int $roomID,
		public ?string $rateCode,
		public ?int $propertyRoomTypeID,
		public int $mealBasisID,
		public string $name,
		public ?string $view,
		public int $adults,
		public int $children,
		public int $infants,
		public ?bool $onRequest,
		public float $subTotal,
		public float $total,
		public RoomsAppliesTo $roomsAppliesTo,
		public ?Supplements $supplements = null,
		public ?SpecialOffers $specialOffers = null,
		public ?Taxes $taxes = null,
		public ?CancellationPolicies $cancellationPolicies = null,
	){}
}