<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Common\LeadGuest;
use XMLWorld\ApiClient\Requests\BookDetails;
use XMLWorld\ApiClient\Requests\RoomBookings;

class BookDetailsTest extends RoomBookingsTest
{
    /**
     * @depends testRoomBookingTwoAdults
     */
    public function testOneRoomBookingDetails($roomBookingTwoAdults)
    {
        $simpleLeadGuestBook = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr'
        );

        $oneRoomBookingDetails = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
            $simpleLeadGuestBook,
            null,
            new RoomBookings($roomBookingTwoAdults)
        );

        $this->serialize(
            '<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
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
				</RoomBookings>
			</BookDetails>',
            $oneRoomBookingDetails
        );

        $this->unserialize(
            '<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
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
				</RoomBookings>
			</BookDetails>',
            $oneRoomBookingDetails
        );

        return $oneRoomBookingDetails;
    }

    /**
     * @depends testTwoRoomBookings
     */
    public function testTwoRoomBookingDetails($twoRoomBookings)
    {
        $simpleLeadGuestBook = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr'
        );

        $oneRoomBookingDetails = new BookDetails(
            '2023-11-01',
            5,
            'TEST_REF',
            1040,
            $simpleLeadGuestBook,
            null,
            $twoRoomBookings
        );

        $this->serialize(
            '<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
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
				</RoomBookings>
			</BookDetails>',
            $oneRoomBookingDetails
        );

        $this->unserialize(
            '<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
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
				</RoomBookings>
			</BookDetails>',
            $oneRoomBookingDetails
        );

        return $oneRoomBookingDetails;
    }

}