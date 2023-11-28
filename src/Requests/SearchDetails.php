<?php

namespace xmlworld\apiclient\Requests;

class SearchDetails extends AbstractRequest
{
	public function __construct(
		public string $arrivalDate,
		public int $duration,
		public RoomRequests $roomRequests,
		public ?Properties $properties = null,
		public ?int $propertyID = null,
		public ?int $mealBasisID = null,
		public ?int $minStarRating = null,
		public ?int $minimumPrice = null,
		public ?int $maximumPrice = null
	){}
}