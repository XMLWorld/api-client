<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SearchResponse;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchResponseTests extends PropertyResultTests
{
    /**
     * @depends testResponseInfo
     * @depends testReturnStatusTrue
     * @depends testOnePropertyResult
     */
    public function testSearchResponseOneProperty($requestInfo, $returnStatusTrue, $onePropertyResult)
    {
        $searchResponseOneProperty = new SearchResponse(
            $requestInfo,
            $returnStatusTrue,
            $onePropertyResult
        );

        $this->serialize(
            '<SearchResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<PropertyResults>
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
				</PropertyResults>
			</SearchResponse>',
            $searchResponseOneProperty
        );

        $this->unserialize(
            '<SearchResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<PropertyResults>
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
								<PropertyRoomTypeID/>
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
					</PropertyResult>
				</PropertyResults>
			</SearchResponse>',
            $searchResponseOneProperty
        );

        return $searchResponseOneProperty;
    }
}