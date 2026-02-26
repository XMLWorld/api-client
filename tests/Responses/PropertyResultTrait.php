<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\PropertyResult;
use XMLWorld\ApiClient\Responses\PropertyResults;

trait PropertyResultTrait
{
	use SupplierTrait;
	use RoomTypesTrait;
	use ImagesTrait;
	use ErrataTrait;

	protected function getPropertyResult0() : array
	{
		list($twoRoomTypesInstance,	$twoRoomTypesSerialize, $twoRoomTypesUnserialize)	= $this->getOneRoomTypes($this->getRoomType0());
		list($supplierInstance, 	$supplierSerialize, 	$supplierUnserialize) 		= $this->getRMISupplier();

		$instance = new PropertyResult(
			99,
			$twoRoomTypesInstance,
			'Example Island',
			null,
			'USD',
			4.5,
			null,
			null,
			null,
			'West Indies',
			'St Vincent & Grenadines',
			'Example Island',
			null,
			null,
			null,
			null,
			null,
			null,
			'Intimate, exotic and all-inclusive',
			'Example Island, a high-end luxury resort',
			'https://xmlhost/custom/content/',
			'CMSImage_999.jpg',
			'CMSImageThumb_999.jpg',
			null,
			null,
			$supplierInstance
		);

		$serialize = <<<XML
<PropertyResult>
	<PropertyID>99</PropertyID>
	$twoRoomTypesSerialize
	<PropertyName>Example Island</PropertyName>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	$supplierSerialize
</PropertyResult>
XML;

		$unserialize = <<<XML
<PropertyResult>
	<PropertyID>99</PropertyID>
	$twoRoomTypesUnserialize
	<PropertyName>Example Island</PropertyName>
	$supplierUnserialize
	<GIATAID/>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<GeographyLevel1ID/>
	<GeographyLevel3ID/>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Email/>
	<Postcode/>
	<Address1/>
	<Address2/>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	<Images/>
	<Errata/>
</PropertyResult>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

    protected function getPropertyResult1() : array
    {
		list($oneRoomTypesInstance,	$oneRoomTypesSerialize, $oneRoomTypesUnserialize)	= $this->getOneRoomTypes($this->getRoomType1());
		list($oneImageInstance, 	$oneImageSerialize, 	$oneImageUnserialize) 		= $this->getOneImages($this->getImage1());
		list($oneErrataInstance,	$oneErrataSerialize,	$oneErrataUnserialize)		= $this->getOneErrata($this->getErratum1());
		list($supplierInstance, 	$supplierSerialize, 	$supplierUnserialize) 		= $this->getRMISupplier();

        $instance = new PropertyResult(
            100,
			$oneRoomTypesInstance,
            'Example Island',
            99999,
            'USD',
            4.5,
            6,
            10,
            22,
            'West Indies',
            'St Vincent & Grenadines',
            'Example Island',
            null,
            null,
            null,
            null,
            null,
            null,
            'Intimate, exotic and all-inclusive',
            'Example Island, a high-end luxury resort',
            'https://xmlhost/custom/content/',
            'CMSImage_999.jpg',
            'CMSImageThumb_999.jpg',
			$oneImageInstance,
			$oneErrataInstance,
			$supplierInstance
        );

        $serialize = <<<XML
<PropertyResult>
	<PropertyID>100</PropertyID>
	$oneRoomTypesSerialize
	<PropertyName>Example Island</PropertyName>
	<GIATAID>99999</GIATAID>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<GeographyLevel1ID>6</GeographyLevel1ID>
	<GeographyLevel2ID>10</GeographyLevel2ID>
	<GeographyLevel3ID>22</GeographyLevel3ID>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	$oneImageSerialize
	$oneErrataSerialize
	$supplierSerialize
</PropertyResult>
XML;

        $unserialize = <<<XML
<PropertyResult>
	<PropertyID>100</PropertyID>
	$oneRoomTypesUnserialize
	<PropertyName>Example Island</PropertyName>
	$supplierUnserialize
	<GIATAID>99999</GIATAID>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<GeographyLevel1ID>6</GeographyLevel1ID>
	<GeographyLevel2ID>10</GeographyLevel2ID>
	<GeographyLevel3ID>22</GeographyLevel3ID>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Email/>
	<Postcode/>
	<Address1/>
	<Address2/>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	$oneImageUnserialize
	$oneErrataUnserialize
</PropertyResult>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getPropertyResult2() : array
	{
		list($twoRoomTypesInstance,	$twoRoomTypesSerialize, $twoRoomTypesUnserialize)	= $this->getTwoRoomTypes($this->getRoomType1(), $this->getRoomType2());
		list($twoImageInstance, 	$twoImageSerialize, 	$twoImageUnserialize) 		= $this->getTwoImages($this->getImage1(), $this->getImage2());
		list($twoErrataInstance,	$twoErrataSerialize,	$twoErrataUnserialize)		= $this->getTwoErrata($this->getErratum1(), $this->getErratum2());
		list($supplierInstance, 	$supplierSerialize, 	$supplierUnserialize) 		= $this->getRMISupplier();

		$instance = new PropertyResult(
			101,
			$twoRoomTypesInstance,
			'Example Island',
			99997,
			'USD',
			4.5,
			6,
			10,
			22,
			'West Indies',
			'St Vincent & Grenadines',
			'Example Island',
			null,
			null,
			null,
			null,
			null,
			null,
			'Intimate, exotic and all-inclusive',
			'Example Island, a high-end luxury resort',
			'https://xmlhost/custom/content/',
			'CMSImage_999.jpg',
			'CMSImageThumb_999.jpg',
			$twoImageInstance,
			$twoErrataInstance,
			$supplierInstance
		);

		$serialize = <<<XML
<PropertyResult>
	<PropertyID>101</PropertyID>
	$twoRoomTypesSerialize
	<PropertyName>Example Island</PropertyName>
	<GIATAID>99997</GIATAID>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<GeographyLevel1ID>6</GeographyLevel1ID>
	<GeographyLevel2ID>10</GeographyLevel2ID>
	<GeographyLevel3ID>22</GeographyLevel3ID>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	$twoImageSerialize
	$twoErrataSerialize
	$supplierSerialize
</PropertyResult>
XML;

		$unserialize = <<<XML
<PropertyResult>
	<PropertyID>101</PropertyID>
	$twoRoomTypesUnserialize
	<PropertyName>Example Island</PropertyName>
	$supplierUnserialize
	<GIATAID>99997</GIATAID>
	<Currency>USD</Currency>
	<Rating>4.5</Rating>
	<GeographyLevel1ID>6</GeographyLevel1ID>
	<GeographyLevel2ID>10</GeographyLevel2ID>
	<GeographyLevel3ID>22</GeographyLevel3ID>
	<Country>West Indies</Country>
	<Area>St Vincent &amp; Grenadines</Area>
	<Region>Example Island</Region>
	<Email/>
	<Postcode/>
	<Address1/>
	<Address2/>
	<Strapline>Intimate, exotic and all-inclusive</Strapline>
	<Description>Example Island, a high-end luxury resort</Description>
	<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
	<MainImage>CMSImage_999.jpg</MainImage>
	<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
	$twoImageUnserialize
	$twoErrataUnserialize
</PropertyResult>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getOnePropertyResult(array $propertyResult) : array
    {
		list($instance, $serialize, $unserialize) = $propertyResult;

		$instance = PropertyResults::fromPropertyResults($instance);

        $serialize = <<<XML
<PropertyResults>
	<TotalProperties>1</TotalProperties>
	$serialize
</PropertyResults>
XML;

        $unserialize = <<<XML
<PropertyResults>
	<TotalProperties>1</TotalProperties>
	$unserialize
</PropertyResults>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoPropertyResults(array $propertyResult1, array $propertyResult2)
    {
		list($propertyResult1Instance, $propertyResult1Serialize, $propertyResult1Unserialize) = $propertyResult1;
		list($propertyResult2Instance, $propertyResult2Serialize, $propertyResult2Unserialize) = $propertyResult2;

		$instance = PropertyResults::fromPropertyResults(
			$propertyResult1Instance,
			$propertyResult2Instance
        );

        $serialize = <<<XML
<PropertyResults>
	<TotalProperties>2</TotalProperties>
	$propertyResult1Serialize
	$propertyResult2Serialize
</PropertyResults>
XML;

        $unserialize = <<<XML
<PropertyResults>
	<TotalProperties>2</TotalProperties>
	$propertyResult1Unserialize
	$propertyResult2Unserialize
</PropertyResults>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}