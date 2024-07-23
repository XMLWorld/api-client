<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\Property;
use XMLWorld\ApiClient\Responses\Supplier;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
    public function testMinProperty()
    {
        $supplier = new Supplier(6, 'RMI');

        $minProperty = new Property(
            70011,
            'BUSY ROOMS HOTEL EMEA',
            $supplier,
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

        $this->serialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<Rating>4</Rating>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
			</Property>',
            $minProperty
        );

        $this->unserialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
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
			</Property>',
            $minProperty
        );

        return $minProperty;
    }

    public function testSympleProperty()
    {
        $supplier = new Supplier(6, 'RMI');

        $sympleProperty = new Property(
            70011,
            'BUSY ROOMS HOTEL EMEA',
            $supplier,
            123,
            4,
            new Errata(new Erratum(
                '2020-08-04',
                '2020-08-11',
                'Small pool will be closed for maintenance'
            )),
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
            new Images(new Image(
                'CMSImage_1000.jpg',
                'CMSImageThumb_1000.jpg'
            ))
        );

        $this->serialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
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
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
            $sympleProperty
        );

        $this->unserialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
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
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
            $sympleProperty
        );

        return $sympleProperty;
    }

    public function testComplexProperty()
    {
        $supplier = new Supplier(6, 'RMI');

        $complexProperty = new Property(
            70011,
            'BUSY ROOMS HOTEL EMEA',
            $supplier,
            123,
            4,
            new Errata(
                new Erratum(
                    '2020-08-04',
                    '2020-08-11',
                    'Small pool will be closed for maintenance'
                ),
                new Erratum(
                    '2020-08-04',
                    '2020-08-11',
                    'There won\'t be mayonese at the restaurant'
                )
            ),
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
            new Images(
                new Image(
                    'CMSImage_1000.jpg',
                    'CMSImageThumb_1000.jpg'
                ),
                new Image(
                    'CMSImage_1001.jpg',
                    'CMSImageThumb_1001.jpg'
                )
            )
        );

        $this->serialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>There won\'t be mayonese at the restaurant</Description>
					</Erratum>
				</Errata>
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
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
            $complexProperty
        );

        $this->unserialize(
            '<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>There won\'t be mayonese at the restaurant</Description>
					</Erratum>
				</Errata>
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
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
            $complexProperty
        );

        return $complexProperty;
    }
}