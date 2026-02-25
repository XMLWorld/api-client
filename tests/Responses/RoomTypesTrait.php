<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\RoomType;
use XMLWorld\ApiClient\Responses\RoomTypes;

trait RoomTypesTrait
{
	use RoomsAppliesToTrait;
	use SupplementsTrait;
	use SpecialOffersTrait;
	use TaxesTrait;
	use CancellationPoliciesTrait;

    public function getRoomTypeOne()
    {
		list($roomsAppliesToInstance, 	$roomsAppliesToSerialize, 	$roomsAppliesToUnserialize) 	= $this->getRoomsAppliesTo();
		list($oneSupplementsInstance, 	$oneSupplementsSerialize, 	$oneSupplementsUnserialize)		= $this->getOneSupplements();
		list($twoSpecialOffertInstance,	$twoSpecialOffertSerialize, $twoSpecialOffertUnserialize)	= $this->getTwoSpecialOffers();
		list($taxesInstance, 			$taxesSerialize, 			$taxesUnserialize) 				= $this->getTaxes();
		list($twoCancellationsInstance,	$twoCancellationsSerialize,	$twoCancellationsUnserialize) 	= $this->getCancellationPolicies();

        $instance = new RoomType(
            999,
            null,
            1,
            1,
            'Example Villa',
            'Sea View',
            2,
            2,
            1,
            true,
            5896.80,
            6565.35,
			$roomsAppliesToInstance,
			$oneSupplementsInstance,
			$twoSpecialOffertInstance,
			$taxesInstance,
			$twoCancellationsInstance,
        );

        $serialize = <<<XML
<RoomType>
	<RoomID>999</RoomID>
	<PropertyRoomTypeID>1</PropertyRoomTypeID>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>2</Adults>
	<Children>2</Children>
	<Infants>1</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>5896.8</SubTotal>
	<Total>6565.35</Total>
	$roomsAppliesToSerialize
	$oneSupplementsSerialize
	$twoSpecialOffertSerialize
	$taxesSerialize
	$twoCancellationsSerialize
</RoomType>
XML;

        $unserialize = <<<XML
<RoomType>
	<RoomID>999</RoomID>
	<PropertyRoomTypeID>1</PropertyRoomTypeID>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>2</Adults>
	<Children>2</Children>
	<Infants>1</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>5896.8</SubTotal>
	<Total>6565.35</Total>
	$roomsAppliesToUnserialize
	$oneSupplementsUnserialize
	$twoSpecialOffertUnserialize
	$taxesUnserialize
	$twoCancellationsUnserialize
</RoomType>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getRoomTypeTwo()
    {

		list($oneSpecialOffertsInstance,	$oneSpecialOffertsSerialize,	$oneSpecialOffertsUnserialize)	= $this->getOneSpecialOffers();
		list($oneTaxesInstance, 			$oneTaxesSerialize, 			$oneTaxesUnserialize) 			= $this->getOneTaxes();
		list($oneCancellationsInstance, 	$oneCancellationsSerialize, 	$oneCancellationsUnserialize) 	= $this->getOneCancellationPolicies();

        $instance = new RoomType(
            998,
            null,
            null,
            1,
            'Example Villa',
            'Sea View',
            2,
            0,
            0,
            true,
            3960,
            4400,
            new RoomsAppliesTo(2),
            null,
			$oneSpecialOffertsInstance,
			$oneTaxesInstance,
			$oneCancellationsInstance,
        );

        $serialize = <<<XML
<RoomType>
	<RoomID>998</RoomID>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>3960</SubTotal>
	<Total>4400</Total>
	<RoomsAppliesTo>
		<RoomRequest>2</RoomRequest>
	</RoomsAppliesTo>
	$oneSpecialOffertsSerialize
	$oneTaxesSerialize
	$oneCancellationsSerialize
</RoomType>
XML;

        $unserialize = <<<XML
<RoomType>
	<RoomID>998</RoomID>
	<PropertyRoomTypeID/>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>3960</SubTotal>
	<Total>4400</Total>
	<RoomsAppliesTo>
		<RoomRequest>2</RoomRequest>
	</RoomsAppliesTo>
	<Supplements/>
	$oneSpecialOffertsUnserialize
	$oneTaxesUnserialize
	$oneCancellationsUnserialize
</RoomType>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getOneRoomType()
    {
		list($instance, $serialize, $unserialize) = $this->getRoomTypeOne();

		$instance = new RoomTypes($instance);

        $serialize = <<<XML
<RoomTypes>
	$serialize
</RoomTypes>
XML;

        $unserialize = <<<XML
<RoomTypes>
	$unserialize
</RoomTypes>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoRoomTypes()
    {
		$instance = $serialize = $unserialize = [];
		list($instance[0], $serialize[0], $unserialize[0]) = $this->getRoomTypeOne();
		list($instance[1], $serialize[1], $unserialize[1]) = $this->getRoomTypeTwo();

		$instance = new RoomTypes(
			$instance[0],
			$instance[1]
        );

        $serialize = <<<XML
<RoomTypes>
	$serialize[0]
	$serialize[1]
</RoomTypes>
XML;

        $unserialize = <<<XML
<RoomTypes>
	$unserialize[0]
	$unserialize[1]
</RoomTypes>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}