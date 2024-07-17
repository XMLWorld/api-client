<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends BaseSerializeXML
{
    public function testRoomBooking()
    {
        $roomBookingOneAdult = new RoomBooking(
            155558,
            1,
            1,
            0,
            0,
            new Guests(new Guest(
                'Adult',
                'Sally',
                'Smith',
                'Mrs',
                null,
                'French'
            ))
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
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
			</RoomBooking>',
            $roomBookingOneAdult
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
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
			</RoomBooking>',
            $roomBookingOneAdult
        );

        return $roomBookingOneAdult;
    }


    /**
     * @depends testErratum
     */
    public function testOneErrata($erratum)
    {
        $oneErratum = new Errata($erratum);

        $this->serialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
            $oneErratum
        );

        $this->unserialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
            $oneErratum
        );

        return $oneErratum;
    }

    /**
     * @depends testErratum
     */
    public function testTwoErrata($erratum)
    {
        $twoErrata = new Errata(
            $erratum,
            new Erratum(
                '2020-08-04',
                '2020-08-11',
                'There won\'t be mayonese at the restaurant'
            )
        );

        $this->serialize(
            '<Errata>
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
			</Errata>',
            $twoErrata
        );

        $this->unserialize(
            '<Errata>
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
			</Errata>',
            $twoErrata
        );

        return $twoErrata;
    }

}