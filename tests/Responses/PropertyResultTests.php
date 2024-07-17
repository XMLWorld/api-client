<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\PropertyResult;
use XMLWorld\ApiClient\Responses\PropertyResults;
use XMLWorld\ApiClient\Responses\Supplier;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertyResultTests extends RoomTypesTests
{
    public function testSupplier()
    {
        $supplier = new Supplier(
            6,
            'RMI'
        );

        $this->serialize(
            '<Supplier>
				<SupplierID>6</SupplierID>
				<SupplierName>RMI</SupplierName>
			</Supplier>',
            $supplier
        );

        $this->unserialize(
            '<Supplier>
				<SupplierID>6</SupplierID>
				<SupplierName>RMI</SupplierName>
			</Supplier>',
            $supplier
        );

        return $supplier;
    }

    /**
     * @depends testSupplier
     * @depends testTwoRoomTypes
     */
    public function testPropertyResult($supplier, $twoRoomTypes)
    {
        $propertyResult = new PropertyResult(
            99,
            $twoRoomTypes,
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
            new Images(
                new Image(
                    'CMSImage_1000.jpg',
                    'CMSImageThumb_1000.jpg'
                ),
                new Image(
                    'CMSImage_1001.jpg',
                    'CMSImageThumb_1001.jpg'
                )
            ),
            new Errata(new Erratum(
                '2020-08-04',
                '2020-08-11',
                'Small pool will be closed for maintenance'
            )),
            $supplier
        );

        $this->serialize(
            '<PropertyResult>
				<PropertyID>99</PropertyID>
				<RoomTypes>
					<RoomType>
						<RoomID>999</RoomID>
						<PropertyRoomTypeID>1</PropertyRoomTypeID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>2</Children>
						<Infants>1</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>5896.8</SubTotal>
						<Total>6565.35</Total>
						<RoomsAppliesTo>
							<RoomRequest>1</RoomRequest>
						</RoomsAppliesTo>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>test %</TaxName>
								<Inclusive>False</Inclusive>
								<Total>1148.55</Total>
							</Tax>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
							<Tax>
								<TaxName>Service Charge</TaxName>
								<Inclusive>True</Inclusive>
								<Total>604.5</Total>
							</Tax>
							<Tax>
								<TaxName>test</TaxName>
								<Inclusive>False</Inclusive>
								<Total>300</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
					<RoomType>
						<RoomID>998</RoomID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>3960</SubTotal>
						<Total>4400</Total>
						<RoomsAppliesTo>
							<RoomRequest>2</RoomRequest>
						</RoomsAppliesTo>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Early Bird Booking</Name>
								<Type>Adult Only</Type>
								<Value>10</Value>
								<PaxType>All</PaxType>
								<Total>440</Total>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>440</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
				</RoomTypes>
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
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
			</PropertyResult>',
            $propertyResult
        );

        $this->unserialize(
            '<PropertyResult>
				<PropertyID>99</PropertyID>
				<RoomTypes>
					<RoomType>
						<RoomID>999</RoomID>
						<PropertyRoomTypeID>1</PropertyRoomTypeID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>2</Children>
						<Infants>1</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>5896.8</SubTotal>
						<Total>6565.35</Total>
						<RoomsAppliesTo>
							<RoomRequest>1</RoomRequest>
						</RoomsAppliesTo>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>test %</TaxName>
								<Inclusive>False</Inclusive>
								<Total>1148.55</Total>
							</Tax>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
							<Tax>
								<TaxName>Service Charge</TaxName>
								<Inclusive>True</Inclusive>
								<Total>604.5</Total>
							</Tax>
							<Tax>
								<TaxName>test</TaxName>
								<Inclusive>False</Inclusive>
								<Total>300</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
					<RoomType>
						<RoomID>998</RoomID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>3960</SubTotal>
						<Total>4400</Total>
						<RoomsAppliesTo>
							<RoomRequest>2</RoomRequest>
						</RoomsAppliesTo>
						<Supplements/>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Early Bird Booking</Name>
								<Type>Adult Only</Type>
								<Value>10</Value>
								<PaxType>All</PaxType>
								<Total>440</Total>
								<Desc/>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>440</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
				</RoomTypes>
				<PropertyName>Example Island</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
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
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
			</PropertyResult>',
            $propertyResult
        );

        return $propertyResult;
    }

    /**
     * @depends testPropertyResult
     */
    public function testOnePropertyResult($propertyResult)
    {
        $onePropertyResult = PropertyResults::fromPropertyResults($propertyResult);

        $this->serialize(
            '<PropertyResults>
				<TotalProperties>1</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
			</PropertyResults>',
            $onePropertyResult
        );

        $this->unserialize(
            '<PropertyResults>
				<TotalProperties>1</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
			</PropertyResults>',
            $onePropertyResult
        );

        return $onePropertyResult;
    }

    /**
     * @depends testPropertyResult
     */
    public function testTwoPropertyResults($propertyResult)
    {
        $twoPropertyResults = PropertyResults::fromPropertyResults(
            $propertyResult,
            $propertyResult
        );

        $this->serialize(
            '<PropertyResults>
				<TotalProperties>2</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
			</PropertyResults>',
            $twoPropertyResults
        );

        $this->unserialize(
            '<PropertyResults>
				<TotalProperties>2</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Desc/>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
								<Tax>
									<TaxName>Service Charge</TaxName>
									<Inclusive>True</Inclusive>
									<Total>604.5</Total>
								</Tax>
								<Tax>
									<TaxName>test</TaxName>
									<Inclusive>False</Inclusive>
									<Total>300</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
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
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
			</PropertyResults>',
            $twoPropertyResults
        );

        return $twoPropertyResults;
    }
}