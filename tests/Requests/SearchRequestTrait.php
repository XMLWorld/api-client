<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;

Trait SearchRequestTrait
{
    /**
     * @depends testLoginDetails
     * @depends testThreeRoomRequests
     */
    public function testSearchRequestOneProperty($loginDetails, $testThreeRoomRequests)
    {
        list($loginDetailsInstance, $loginDetailsSerialize, $loginDetailsUnserialize) = $loginDetails;
        list($testThreeRoomRequestsInstance, $testThreeRoomRequestsSerialize, $testThreeRoomRequestsUnserialize) = $testThreeRoomRequests;

        $instance = new SearchRequest(
            $loginDetailsInstance,
            new SearchDetails(
                '2023-08-01',
                7,
                $testThreeRoomRequestsInstance,
                null,
                2007,
                0,
                0,
                0,
                0
            ),
            true
        );

        $serialize = "<SearchRequest>
				{$loginDetailsSerialize}
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					{$testThreeRoomRequestsSerialize}
					<PropertyID>2007</PropertyID>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
				</SearchDetails>
			</SearchRequest>";

        $unserialize = "<SearchRequest>
				{$loginDetailsUnserialize}
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<!-- a comment -->
					<PropertyID>2007</PropertyID>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
					{$testThreeRoomRequestsUnserialize}
				</SearchDetails>
			</SearchRequest>";

        $searchRequestOneProperty = [
            $instance,
            $serialize,
            $unserialize
        ];

        $this->doTest(...$searchRequestOneProperty);

        return $searchRequestOneProperty;
    }

    /**
     * @depends testLoginDetails
     * @depends testThreeRoomRequests
     * @depends testTwoProperties
     */
    public function testSearchRequestTwoProprties($loginDetails, $testThreeRoomRequests, $twoProperties){

        list($loginDetailsInstance, $loginDetailsSerialize, $loginDetailsUnserialize) = $loginDetails;
        list($testThreeRoomRequestsInstance, $testThreeRoomRequestsSerialize, $testThreeRoomRequestsUnserialize) = $testThreeRoomRequests;
        list($twoPropertiesInstance, $twoPropertiesSerialize, $twoPropertiesUnserialize) = $twoProperties;

        $instance = new SearchRequest(
            $loginDetailsInstance,
            new SearchDetails(
                '2023-08-01',
                7,
                $testThreeRoomRequestsInstance,
                $twoPropertiesInstance,
                null,
                0,
                0,
                0,
                0
            ),
            true
        );

        $serialize = "<SearchRequest>
				{$loginDetailsSerialize}
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					{$testThreeRoomRequestsSerialize}
					{$twoPropertiesSerialize}
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
				</SearchDetails>
			</SearchRequest>";

        $unserialize = "<SearchRequest>
				{$loginDetailsUnserialize}
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					{$twoPropertiesUnserialize}
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
					{$testThreeRoomRequestsUnserialize}
				</SearchDetails>
			</SearchRequest>";

        $twoRoomSearchRequest = [
            $instance,
            $serialize,
            $unserialize
        ];

        $this->doTest(...$twoRoomSearchRequest);

        return $twoRoomSearchRequest;
    }
}