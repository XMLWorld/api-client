<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

/**
 * @method testRequestInfo
 *
 * @method testRequestStatusTrue
 * @method testReturnBookingStatusFalse
 * @method testReturnSerachStatusFalse
 *
 * @method testRoomsAppliesTo
 * @method testRoomsAppliesToFourRooms
 *
 * @method testSupplementWeekend
 * @method testSupplement
 * @method testOneSupplements
 * @method testTwoSupplements
 *
 * @method testSpecialOffer1
 * @method testSpecialOffer2
 * @method testOneSpecialOffers
 * @method testTwoSpecialOffers
 *
 * @method testTax
 * @method testOneTaxes
 */
class ResponsesTest extends BaseSerializeXML
{
    use RequestInfoTrait;
    use ReturnStatusTrait;
    use RoomsAppliesToTrait;
    use SupplementsTrait;
    use SpecialOffersTrait;
    use TaxesTrait;
}