<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\RoomType;
use XMLWorld\ApiClient\Responses\RoomTypes;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomTypesTests extends ResponseTest
{
    public function testRoomTypeOne()
    {
        $roomTypeOne = new RoomType(
            999,
            null,
            1,
            1,
            'Example Villa',
            'Sea View',
            2,
            2,
            1,
            true,
            5896.80,
            6565.35,
            new RoomsAppliesTo(1),
            new Supplements(new Supplement(
                'test supplement',
                'Per Night',
                'Per Person',
                220,
                'Adult Only'
            )),
            new SpecialOffers(
                new SpecialOffer(
                    'Example special offer',
                    'Value Added',
                    null,
                    null,
                    null,
                    'test desc'
                ),
                new SpecialOffer(
                    'Example special offer 2',
                    'Free Kids',
                    1,
                    null,
                    1000,
                    'test desc'
                )
            ),
            new Taxes(
                new Tax(
                    'test %',
                    false,
                    1148.55
                ),
                new Tax(
                    'Government Tax',
                    true,
                    423.15
                ),
                new Tax(
                    'Service Charge',
                    true,
                    604.5
                ),
                new Tax(
                    'test',
                    false,
                    300
                ),
            ),
            new CancellationPolicies(
                new CancellationPolicy(
                    '2020-07-11',
                    574.28
                ),
                new CancellationPolicy(
                    '2020-07-18',
                    1148.55
                )
            ),
        );

        $this->serialize(
            '<RoomType>
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
			</RoomType>',
            $roomTypeOne
        );

        $this->unserialize(
            '<RoomType>
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
			</RoomType>',
            $roomTypeOne
        );

        return $roomTypeOne;
    }

    public function testRoomTypeTwo()
    {
        $roomTypeTwo = new RoomType(
            998,
            null,
            null,
            1,
            'Example Villa',
            'Sea View',
            2,
            0,
            0,
            true,
            3960,
            4400,
            new RoomsAppliesTo(2),
            null,
            new SpecialOffers(
                new SpecialOffer(
                    'Early Bird Booking',
                    'Adult Only',
                    10,
                    'All',
                    440
                )
            ),
            new Taxes(
                new Tax(
                    'Government Tax',
                    true,
                    423.15
                )
            ),
            new CancellationPolicies(
                new CancellationPolicy(
                    '2020-07-18',
                    440
                )
            ),
        );

        $this->serialize(
            '<RoomType>
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
				</RoomType>',
            $roomTypeTwo
        );

        $this->unserialize(
            '<RoomType>
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
				</RoomType>',
            $roomTypeTwo
        );

        return $roomTypeTwo;
    }

    /**
     * @depends testRoomTypeOne
     */
    public function testOneRoomType($roomType)
    {
        $oneRoomType = new RoomTypes($roomType);

        $this->serialize(
            '<RoomTypes>
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
			</RoomTypes>',
            $oneRoomType
        );

        $this->unserialize(
            '<RoomTypes>
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
			</RoomTypes>',
            $oneRoomType
        );

        return $oneRoomType;
    }

    /**
     * @depends testRoomTypeOne
     * @depends testRoomTypeTwo
     */
    public function testTwoRoomTypes($roomTypeOne, $roomTypeTwo)
    {
        $twoRoomTypes = new RoomTypes(
            $roomTypeOne,
            $roomTypeTwo
        );

        $this->serialize(
            '<RoomTypes>
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
			</RoomTypes>',
            $twoRoomTypes
        );

        $this->unserialize(
            '<RoomTypes>
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
			</RoomTypes>',
            $twoRoomTypes
        );

        return $twoRoomTypes;
    }
}