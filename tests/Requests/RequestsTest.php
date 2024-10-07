<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

/**
 * @method testOneProperty
 * @method testTwoProperties
*
 * @method testChildAge
 * @method testOneChildAges
 * @method testTwoChildAges
 *
 * @method testTwoAdults
 * @method testTwoAdultsOneChild
 * @method testTwoAdultsTwoInfants
 * @method testTwoAdultsTwoChildrenTwoInfants
 * @method testOneChildTwoInfants
 * @method testTwoAdultsOneChildrenTwoInfants
 * @method testRoomRequestsTwoAdults
 * @method testRoomRequestsTwoAdultsTwoInfants
 * @method testRoomRequestsTwoAdultsOneChild
 * @method testRoomRequestsTwoAdultsTwoChildrenTwoInfants
 * @method testThreeRoomRequests
 *
 * @method testLoginDetails
 *
 * @method testSearchRequestOneProperty
 * @method testSearchRequestTwoProperties
 *
 */
class RequestsTest extends BaseSerializeXML
{
    use PropertiesTrait;
    use ChildAgesTrait;
    use RoomRequestsTrait;
    use LoginDetailsTrait;
    use SearchRequestTrait;
}