<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\RoomBooking;
use XMLWorld\ApiClient\Responses\RoomBookings;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingResponsesTest extends BaseSerializeXML
{

    public function testLeadGuestOnlyBookResponse()
    {
        $leadGuestOnlyBookResponse = new RoomBooking(
            155558,
            'Executive Double',
            null,
            6,
            1,
            0,
            0,
            null,
            null,
            null,
            null,
            null,
            1040.23
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $leadGuestOnlyBookResponse
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
				<Supplements/>
				<SpecialOffers/>
				<Taxes/>
				<CancellationPolicies/>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $leadGuestOnlyBookResponse
        );

        return $leadGuestOnlyBookResponse;
    }

    public function testLeadGuestAndGuestBookResponse()
    {
        $leadGuestAndGuestBookResponse = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            2,
            0,
            0,
            new Guests(new Guest(
                'Adult',
                'Sally',
                'Smith',
                'Mrs',
                null,
                'French'
            )),
            new Supplements(new Supplement(
                'test supplement',
                'Per Night',
                'Per Person',
                220,
                'Adult Only'
            )),
            new SpecialOffers(new SpecialOffer(
                'Example special offer',
                'Value Added',
                null,
                null,
                null,
                'test desc'
            )),
            new Taxes(new Tax(
                'test %',
                false,
                1148.55
            )),
            new CancellationPolicies(new CancellationPolicy(
                '2020-07-11',
                574.28
            )),
            1040.23
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
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
				</SpecialOffers>
				<Taxes>
					<Tax>
						<TaxName>test %</TaxName>
						<Inclusive>False</Inclusive>
						<Total>1148.55</Total>
					</Tax>
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $leadGuestAndGuestBookResponse
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
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
				</SpecialOffers>
				<Taxes>
					<Tax>
						<TaxName>test %</TaxName>
						<Inclusive>False</Inclusive>
						<Total>1148.55</Total>
					</Tax>
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $leadGuestAndGuestBookResponse
        );

        return $leadGuestAndGuestBookResponse;
    }

    public function testAdultAndChildBookResponse()
    {
        $adultAndChildBookResponse = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            1,
            1,
            0,
            new Guests(
                new Guest(
                    'Adult',
                    'Sally',
                    'Smith',
                    'Mrs',
                    null,
                    'French'
                ),
                new Guest(
                    'Child',
                    'Jimmy',
                    'Smith',
                    null,
                    5,
                    'French'
                )
            ),
            new Supplements(
                new Supplement(
                    'Weekend Stay (Fri - Sun)',
                    'Per Night',
                    'Per Room',
                    60,
                ),
                new Supplement(
                    'test supplement',
                    'Per Night',
                    'Per Person',
                    220,
                    'Adult Only'
                ),
            ),
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
            1040.23
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>Weekend Stay (Fri - Sun)</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Room</Multiplier>
						<Total>60</Total>
					</Supplement>
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
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $adultAndChildBookResponse
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>Weekend Stay (Fri - Sun)</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Room</Multiplier>
						<Total>60</Total>
					</Supplement>
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
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $adultAndChildBookResponse
        );

        return $adultAndChildBookResponse;
    }

    public function testNoSupplementsEOTaxesCancellationsBookResponse()
    {
        $noSupplementsEOTaxesCancellationsBookResponse = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            2,
            0,
            0,
            new Guests(new Guest(
                'Adult',
                'Sally',
                'Smith',
                'Mrs',
                null,
                'French'
            )),
            null,
            null,
            null,
            null,
            1040.23
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $noSupplementsEOTaxesCancellationsBookResponse
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements/>
				<SpecialOffers/>
				<Taxes/>
				<CancellationPolicies/>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
            $noSupplementsEOTaxesCancellationsBookResponse
        );

        return $noSupplementsEOTaxesCancellationsBookResponse;
    }

    /**
     * @depends testLeadGuestOnlyBookResponse
     */
    public function testOneRoomBooking($leadGuestOnlyBookResponse)
    {
        $oneRoomBooking = new RoomBookings($leadGuestOnlyBookResponse);

        $this->serialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests/>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
            $oneRoomBooking
        );

        $this->unserialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests/>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
            $oneRoomBooking
        );

        return $oneRoomBooking;
    }

    /**
     * @depends testLeadGuestAndGuestBookResponse
     * @depends testAdultAndChildBookResponse
     */
    public function testTwoRoomBooking($leadGuestAndGuestBookResponse, $adultAndChildBookResponse)
    {
        $twoRoomBooking = new RoomBookings(
            $leadGuestAndGuestBookResponse,
            $adultAndChildBookResponse
        );

        $this->serialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
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
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>test %</TaxName>
							<Inclusive>False</Inclusive>
							<Total>1148.55</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>Weekend Stay (Fri - Sun)</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Room</Multiplier>
							<Total>60</Total>
						</Supplement>
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
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
            $twoRoomBooking
        );

        $this->unserialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
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
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>test %</TaxName>
							<Inclusive>False</Inclusive>
							<Total>1148.55</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>Weekend Stay (Fri - Sun)</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Room</Multiplier>
							<Total>60</Total>
						</Supplement>
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
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
            $twoRoomBooking
        );

        return $twoRoomBooking;
    }
}