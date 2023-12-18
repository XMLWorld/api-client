<?php


namespace XMLWorld\ApiClient\Responses;

class Property extends AbstractResponse
{
	public function __construct(
		public string $propertyID,
		public string $propertyName,
		public Supplier $supplier,
		public ?int $gIATAID = null,
		public int $rating,
		public ?Errata $errata = null,
		public int $geographyLevel1ID,
		public int $geographyLevel2ID,
		public int $geographyLevel3ID,
		public ?string $country,
		public ?string $area,
		public ?string $region,
		public string $strapline,
		public string $description,
		public string $cMSBaseURL,
		public string $mainImage,
		public string $mainImageThumbnail,
		public ?Images $images
	){}
}