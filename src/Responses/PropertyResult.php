<?php


namespace XMLWorld\ApiClient\Responses;

class PropertyResult extends AbstractResponse
{
	public function __construct(
		public int $propertyID,
		public RoomTypes $roomTypes,
		public string $propertyName,
		public ?int $gIATAID,
		public string $currency,
		public ?float $rating,
		public ?int $geographyLevel1ID,
		public ?int $geographyLevel2ID,
		public ?int $geographyLevel3ID,
		public string $country,
		public string $area,
		public string $region,
		public ?float $longitude,
		public ?float $latitude,
		public ?string $email,
		public ?string $postcode,
		public ?string $address1,
		public ?string $address2,
		public string $strapline,
		public string $description,
		public string $cMSBaseURL,
		public string $mainImage,
		public string $mainImageThumbnail,
		public ?Images $images,
		public ?Errata $errata,
		public Supplier $supplier
	){}
}