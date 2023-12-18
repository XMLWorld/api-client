<?php

namespace XMLWorld\ApiClient\Responses;

class RoomType extends AbstractResponse
{
	public function __construct(
		public int $roomID,
		public ?string $ratecode = null,
		public ?int $propertyRoomTypeID = null,
		public int $mealBasisID,
		public string $name,
		public ?string $view = null,
		public int $adults,
		public int $children,
		public int $infants,
		public ?bool $onRequest = null,
		public float $subTotal,
		public float $total,
		public RoomsAppliesTo $roomsAppliesTo,
		public ?Supplements $supplements = null,
		public ?SpecialOffers $specialOffers = null,
		public ?Taxes $taxes = null,
		public ?CancellationPolicies $cancellationPolicies = null,
	){}
}