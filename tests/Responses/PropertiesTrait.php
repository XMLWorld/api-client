<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Property;

trait PropertiesTrait
{
	use SupplierTrait;
	use ErrataTrait;
	use ImagesTrait;

    protected function getMinProperty()
    {
		list($supplierInstance, $supplierSerialize, $supplierUnserialize) = $this->getBusyRoomsSupplier();

		$instance = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplierInstance,
			null,
			4,
			null,
			45,
			76,
			87,
			null,
			null,
			null,
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			null
		);

		$serialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierSerialize
	<Rating>4</Rating>
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
</Property>
XML;

		$unserialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierUnserialize
	<GIATAID/>
	<Rating>4</Rating>
	<Errata/>
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Country/>
	<Area/>
	<Region/>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
	<Images/>
</Property>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getSympleProperty()
    {
		list($supplierInstance,		$supplierSerialize, 	$supplierUnserialize) 	= $this->getBusyRoomsSupplier();
		list($oneErrataInstance,	$oneErrataSerialize,	$oneErrataUnserialize)	= $this->getOneErrata($this->getErratum1());
		list($oneImageInstance, 	$oneImageSerialize, 	$oneImageUnserialize) 	= $this->getOneImages($this->getImage1());

        $instance = new Property(
            70011,
            'BUSY ROOMS HOTEL EMEA',
			$supplierInstance,
            123,
            4,
			$oneErrataInstance,
            45,
            76,
            87,
            'United Kingdom',
            'Malta',
            'Malta',
            'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
            'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
            'https://az416281.vo.msecnd.net/hotels/',
            '3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
            '3000-Emea Copy.jpg',
			$oneImageInstance
        );

        $serialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierSerialize
	<GIATAID>123</GIATAID>
	<Rating>4</Rating>
	$oneErrataSerialize
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Country>United Kingdom</Country>
	<Area>Malta</Area>
	<Region>Malta</Region>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
	$oneImageSerialize
</Property>
XML;

        $unserialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierUnserialize
	<GIATAID>123</GIATAID>
	<Rating>4</Rating>
	$oneErrataUnserialize
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Country>United Kingdom</Country>
	<Area>Malta</Area>
	<Region>Malta</Region>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
	$oneImageUnserialize
</Property>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getComplexProperty()
    {
		list($supplierInstance,		$supplierSerialize, 	$supplierUnserialize) 	= $this->getBusyRoomsSupplier();
		list($twoErrataInstance,	$twoErrataSerialize,	$twoErrataUnserialize)	= $this->getTwoErrata($this->getErratum1(), $this->getErratum2());
		list($twoImageInstance, 	$twoImageSerialize, 	$twoImageUnserialize) 	= $this->getTwoImages($this->getImage1(), $this->getImage2());


		$instance = new Property(
            70011,
            'BUSY ROOMS HOTEL EMEA',
			$supplierInstance,
            123,
            4,
			$twoErrataInstance,
            45,
            76,
            87,
            'United Kingdom',
            'Malta',
            'Malta',
            'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
            'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
            'https://az416281.vo.msecnd.net/hotels/',
            '3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
            '3000-Emea Copy.jpg',
			$twoImageInstance
        );

        $serialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierSerialize
	<GIATAID>123</GIATAID>
	<Rating>4</Rating>
	$twoErrataSerialize
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Country>United Kingdom</Country>
	<Area>Malta</Area>
	<Region>Malta</Region>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
	$twoImageSerialize
</Property>
XML;

        $unserialize = <<<XML
<Property>
	<PropertyID>70011</PropertyID>
	<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
	$supplierUnserialize
	<GIATAID>123</GIATAID>
	<Rating>4</Rating>
	$twoErrataUnserialize
	<GeographyLevel1ID>45</GeographyLevel1ID>
	<GeographyLevel2ID>76</GeographyLevel2ID>
	<GeographyLevel3ID>87</GeographyLevel3ID>
	<Country>United Kingdom</Country>
	<Area>Malta</Area>
	<Region>Malta</Region>
	<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
	<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
	<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
	<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
	<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
	$twoImageUnserialize
</Property>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}