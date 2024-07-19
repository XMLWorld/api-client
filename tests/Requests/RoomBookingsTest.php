<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomBookingsTest extends LoginDetailsTest
{
    public function testRoomBookingOneAdultOnly()
    {
        $roomBookingOneAdultOnly = new RoomBooking(
            155558,
            1,
            1,
            0,
            0
        );              //the adult is the Leadguest so no adults here

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
			</RoomBooking>',
            $roomBookingOneAdultOnly
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
			</RoomBooking>',
            $roomBookingOneAdultOnly
        );

        return $roomBookingOneAdultOnly;
    }

    public function testRoomBookingTwoAdults()
    {
        $oneGuest = new Guest(   //this is the second adult.
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

        $roomBookingTwoAdults = new RoomBooking(
            155558,
            1,
            2,
            0,
            0,
            new Guests($oneGuest)
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
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
			</RoomBooking>',
            $roomBookingTwoAdults
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
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
			</RoomBooking>',
            $roomBookingTwoAdults
        );

        return $roomBookingTwoAdults;
    }

    public function testRoomBookingAdultAndChild()
    {
        $adultGuestBook = new Guest(
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

        $childGuestBook = new Guest(
            'Child',
            'Jimmy',
            'Smith',
            null,
            5,
            'French'
        );

        $roomBookingAdultAndChild = new RoomBooking(
            155448,
            1,
            1,
            1,
            0,
            new Guests(
                $adultGuestBook,
                $childGuestBook
            )
        );

        $this->serialize(
            '<RoomBooking>
				<RoomID>155448</RoomID>
				<MealBasisID>1</MealBasisID>
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
			</RoomBooking>',
            $roomBookingAdultAndChild
        );

        $this->unserialize(
            '<RoomBooking>
				<RoomID>155448</RoomID>
				<MealBasisID>1</MealBasisID>
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
			</RoomBooking>',
            $roomBookingAdultAndChild
        );

        return $roomBookingAdultAndChild;
    }

    /**
     * @depends testRoomBookingAdultAndChild
     */
    public function testOneRoomBookings($roomBookingAdultAndChild)
    {
        $oneRoomBookings = new RoomBookings(
            $roomBookingAdultAndChild
        );

        $this->serialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
			</RoomBookings>',
            $oneRoomBookings
        );

        $this->unserialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
			</RoomBookings>',
            $oneRoomBookings
        );

        return $oneRoomBookings;
    }

    /**
     * @depends testRoomBookingTwoAdults
     * @depends testRoomBookingAdultAndChild
     */
    public function testTwoRoomBookings($roomBookingTwoAdult, $roomBookingAdultAndChild)
    {
        $twoRoomBookings = new RoomBookings(
            $roomBookingTwoAdult,
            $roomBookingAdultAndChild
        );

        $this->serialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
			</RoomBookings>',
            $twoRoomBookings
        );

        $this->unserialize(
            '<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
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
				</RoomBooking>
			</RoomBookings>',
            $twoRoomBookings
        );

        return $twoRoomBookings;
    }
}