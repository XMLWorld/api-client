<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\BookRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;

class BookRequestTest extends BookDetailsTest
{
    /**
     * @depends testLoginDetails
     * @depends testTwoRoomBookingDetails
     */
    public function testBookRequest($loginDetails, $twoRoomBookingDetails)
    {
        $bookRequest = new BookRequest(
            $loginDetails,
            $twoRoomBookingDetails,
            true
        );

        $this->serialize('<BookRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookDetails>
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
				</BookDetails>
			</BookRequest>',
            $bookRequest
        );

        $this->unserialize('<BookRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookDetails>
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
				</BookDetails>
			</BookRequest>',
            $bookRequest
        );

        return $bookRequest;
    }
}