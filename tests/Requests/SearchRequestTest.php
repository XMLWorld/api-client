<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;

class SearchRequestTest extends LoginDetailsTest
{
    use LoginDetailsTrait;

    use RoomRequestsTrait {
        testTwoAdultsTwoInfants as traitTwoAdultsTwoInfants;
        testTwoAdultsOneChild as traitTwoAdultsOneChild;
        testThreeRoomRequests as traitThreeRoomRequests;
        testTwoAdultsTwoChildrenTwoInfants as traitTwoAdultsTwoChildrenTwoInfants;
    }

    public function testTwoAdultsTwoInfants()
    {
        return $this->traitTwoAdultsTwoInfants();
    }

    public function testTwoAdultsOneChild()
    {
        return $this->traitTwoAdultsOneChild();
    }

    public function testTwoAdultsTwoChildrenTwoInfants()
    {
        return $this->traitTwoAdultsTwoChildrenTwoInfants();
    }

    /**
     * @depends testTwoAdultsTwoInfants
     * @depends testTwoAdultsOneChild
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testThreeRoomRequests($twoAdultsTwoInfants, $twoAdultsOneChild, $twoAdultsTwoChildrenTwoInfants)
    {
        return $this->traitThreeRoomRequests(...func_get_args());
    }

    use PropertiesTrait {
        testTwoProperties as traitTwoProperties;
    }

    public function testTwoProperties()
    {
        return $this->traitTwoProperties();
    }

    use SearchRequestTrait {
        testSearchRequestOneProperty as traitSearchRequestOneProperty;
        testSearchRequestTwoProperties as traitSearchRequestTwoProprties;
    }

    /**
     * @depends testLoginDetails
     * @depends testThreeRoomRequests
     */
    public function testSearchRequestOneProperty($loginDetails, $testThreeRoomRequests)
    {
        return $this->traitSearchRequestOneProperty(...func_get_args());
    }

    /**
     * @depends testLoginDetails
     * @depends testThreeRoomRequests
     * @depends testTwoProperties
     */
    public function testSearchRequestTwoProprties($loginDetails, $testThreeRoomRequests, $twoProperties)
    {
        return $this->traitSearchRequestTwoProprties(...func_get_args());
    }
}