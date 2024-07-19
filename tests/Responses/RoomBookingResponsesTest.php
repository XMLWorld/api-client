<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\RoomBooking;
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
}