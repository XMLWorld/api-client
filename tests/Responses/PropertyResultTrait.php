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

    protected function getPropertyResult()
    {
		list($twoRoomTypesInstance,	$twoRoomTypesSerialize, $twoRoomTypesUnserialize)	= $this->getTwoRoomTypes();
		list($twoImageInstance, 	$twoImageSerialize, 	$twoImageUnserialize) 		= $this->getTwoImages();
		list($oneErrataInstance,	$oneErrataSerialize,	$oneErrataUnserialize)		= $this->getOneErrata();
		list($supplierInstance, 	$supplierSerialize, 	$supplierUnserialize) 		= $this->getRMISupplier();

        $instance = new PropertyResult(
            99,
			$twoRoomTypesInstance,
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
			$twoImageInstance,
			$oneErrataInstance,
			$supplierInstance
        );

        $serialize = <<<XML
<PropertyResult>
	<PropertyID>99</PropertyID>
	$twoRoomTypesSerialize
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
	$twoImageSerialize
	$oneErrataSerialize
	$supplierSerialize
</PropertyResult>
XML;

        $unserialize = <<<XML
<PropertyResult>
	<PropertyID>99</PropertyID>
	$twoRoomTypesUnserialize
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
	$twoImageUnserialize
	$oneErrataUnserialize
</PropertyResult>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getOnePropertyResult()
    {
		list($instance, $serialize, $unserialize) = $this->getPropertyResult();

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

    protected function getTwoPropertyResults()
    {
		list($instance, $serialize, $unserialize) = $this->getPropertyResult();

		$instance = PropertyResults::fromPropertyResults(
			$instance,
			$instance
        );

        $serialize = <<<XML
<PropertyResults>
	<TotalProperties>2</TotalProperties>
	$serialize
	$serialize
</PropertyResults>
XML;

        $unserialize = <<<XML
<PropertyResults>
	<TotalProperties>2</TotalProperties>
	$unserialize
	$unserialize
</PropertyResults>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}