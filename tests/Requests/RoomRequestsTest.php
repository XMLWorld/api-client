<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

/**
 * @method testTwoAdults
 * @method testTwoAdultsOneChild
 * @method testTwoAdultsTwoInfants
 * @method testTwoAdultsTwoChildrenTwoInfants
 * @method testOneChildTwoInfants
 * @method testTwoAdultsOneChildrenTwoInfants
 */
class RoomRequestsTest extends BaseSerializeXML
{
    use RoomRequestsTrait{
        testRoomRequestsTwoAdults as traitRoomRequestsTwoAdults;
        testRoomRequestsTwoAdultsTwoInfants as traitRoomRequestsTwoAdultsTwoInfants;
        testRoomRequestsTwoAdultsOneChild as traitRoomRequestsTwoAdultsOneChild;
        testRoomRequestsTwoAdultsTwoChildrenTwoInfants as traitRoomRequestsTwoAdultsTwoChildrenTwoInfants;
        testThreeRoomRequests as traitThreeRoomRequests;
    }

    /**
     * @depends testTwoAdults
     */
    public function testRoomRequestsTwoAdults($twoAdults)
    {
        return $this->traitRoomRequestsTwoAdults($twoAdults);
    }

    /**
     * @depends testTwoAdultsTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoInfants($twoAdultsTwoInfants)
    {
        return $this->traitRoomRequestsTwoAdultsTwoInfants($twoAdultsTwoInfants);
    }

    /**
     * @depends testTwoAdultsOneChild
     */
    public function testRoomRequestsTwoAdultsOneChild($twoAdultsOneChild)
    {
        return $this->traitRoomRequestsTwoAdultsOneChild($twoAdultsOneChild);
    }

    /**
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoChildrenTwoInfants($twoAdultsTwoChildrenTwoInfants)
    {
        return $this->traitRoomRequestsTwoAdultsTwoChildrenTwoInfants($twoAdultsTwoChildrenTwoInfants);
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
}