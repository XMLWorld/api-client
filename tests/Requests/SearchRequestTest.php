<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchRequestTest extends BaseSerializeXML
{
    /**
     * @depends \XMLWorld\ApiClient\Test\Requests\LoginDetailsTest::testLoginDetails
     * @depends \XMLWorld\ApiClient\Test\Requests\RoomRequestsTest::testTwoAdultsTwoInfants
     * @depends \XMLWorld\ApiClient\Test\Requests\RoomRequestsTest::testTwoAdultsTwoChildrenTwoInfants
     * @depends \XMLWorld\ApiClient\Test\Requests\PropertiesTest::testTwoProperties
     */
    public function testTwoRoomSearchRequest(
        $loginDetails,
        $twoAdultsTwoInfants,
        $twoAdultsTwoChildrenTwoInfants,
        $twoPropertyIDs
    ){
        $twoRoomSearchRequest = new SearchRequest(
            $loginDetails,
            new SearchDetails(
                '2023-08-01',
                7,
                new RoomRequests(
                    $twoAdultsTwoInfants,
                    $twoAdultsTwoChildrenTwoInfants
                ),
                $twoPropertyIDs,
                null,
                0,
                0,
                0,
                0
            ),
            true
        );

        $this->serialize(
            '<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
					<Properties>
						<PropertyID>2007</PropertyID>
						<PropertyID>3008</PropertyID>
					</Properties>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
				</SearchDetails>
			</SearchRequest>',
            $twoRoomSearchRequest
        );

        $this->unserialize(
            '<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<Properties>
						<PropertyID>2007</PropertyID>
						<PropertyID>3008</PropertyID>
					</Properties>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
				</SearchDetails>
			</SearchRequest>',
            $twoRoomSearchRequest
        );

        return $twoRoomSearchRequest;
    }
}