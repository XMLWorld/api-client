<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;

trait SearchRequestTrait
{
	use LoginDetailsTrait;
	use RoomRequestsTrait;
	use PropertiesTrait;

    protected function getSearchRequestOneProperty()
    {
        list($loginDetailsInstance, 			$loginDetailsSerialize,				$loginDetailsUnserialize) 			= $this->getLoginDetails();
        list($testThreeRoomRequestsInstance,	$testThreeRoomRequestsSerialize,	$testThreeRoomRequestsUnserialize)	= $this->getThreeRoomRequests();

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

        $serialize = <<<XML
<SearchRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	<SearchDetails>
		<ArrivalDate>2023-08-01</ArrivalDate>
		<Duration>7</Duration>
		$testThreeRoomRequestsSerialize
		<PropertyID>2007</PropertyID>
		<MealBasisID>0</MealBasisID>
		<MinStarRating>0</MinStarRating>
		<MinimumPrice>0</MinimumPrice>
		<MaximumPrice>0</MaximumPrice>
	</SearchDetails>
</SearchRequest>
XML;

        $unserialize = <<<XML
<SearchRequest>
	$loginDetailsUnserialize
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
		$testThreeRoomRequestsUnserialize
	</SearchDetails>
</SearchRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize
        ];
    }

    protected function getSearchRequestTwoProperties()
	{
        list($loginDetailsInstance,             $loginDetailsSerialize,             $loginDetailsUnserialize)           = $this->getLoginDetails();
        list($testThreeRoomRequestsInstance,    $testThreeRoomRequestsSerialize,    $testThreeRoomRequestsUnserialize)  = $this->getThreeRoomRequests();
        list($twoPropertiesInstance,            $twoPropertiesSerialize,            $twoPropertiesUnserialize)          = $this->getTwoProperties();

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

        $serialize = <<<XML
<SearchRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	<SearchDetails>
		<ArrivalDate>2023-08-01</ArrivalDate>
		<Duration>7</Duration>
		$testThreeRoomRequestsSerialize
		$twoPropertiesSerialize
		<MealBasisID>0</MealBasisID>
		<MinStarRating>0</MinStarRating>
		<MinimumPrice>0</MinimumPrice>
		<MaximumPrice>0</MaximumPrice>
	</SearchDetails>
</SearchRequest>
XML;

        $unserialize = <<<XML
<SearchRequest>
	$loginDetailsUnserialize
	<Mock>True</Mock>
	<SearchDetails>
		<ArrivalDate>2023-08-01</ArrivalDate>
		<Duration>7</Duration>
		$twoPropertiesUnserialize
		<MealBasisID>0</MealBasisID>
		<MinStarRating>0</MinStarRating>
		<MinimumPrice>0</MinimumPrice>
		<MaximumPrice>0</MaximumPrice>
		$testThreeRoomRequestsUnserialize
	</SearchDetails>
</SearchRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize
        ];
    }
}