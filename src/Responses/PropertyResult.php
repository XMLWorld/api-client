<?php


namespace XmlWorld\ApiClient\Responses;

class PropertyResult extends AbstractResponse
{
	public function __construct(
		public int $propertyID,
		public RoomTypes $roomTypes,
		public string $propertyName,
		public ?int $gIATAID = null,
		public string $currency,
		public ?float $rating = null,
		public ?int $geographyLevel1ID = null,
		public ?int $geographyLevel2ID = null,
		public ?int $geographyLevel3ID = null,
		public string $country,
		public string $area,
		public string $region,
		public ?float $longitude = null,
		public ?float $latitude = null,
		public ?string $email = null,
		public ?string $postcode = null,
		public ?string $address1 = null,
		public ?string $address2 = null,
		public string $strapline,
		public string $description,
		public string $cMSBaseURL,
		public string $mainImage,
		public string $mainImageThumbnail,
		public Images $images,
		public ?Errata $errata = null,
		public Supplier $supplier
	){}

}