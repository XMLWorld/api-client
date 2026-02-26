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

	public function getRoomType0()
	{
		list($roomsAppliesToInstance, 	$roomsAppliesToSerialize, 	$roomsAppliesToUnserialize) 	= $this->getRoomsAppliesTo();

		$instance = new RoomType(
			997,
			null,
			null,
			1,
			'Example Villa',
			'Sea View',
			1,
			0,
			0,
			true,
			4896.80,
			5565.35,
			$roomsAppliesToInstance,
		);

		$serialize = <<<XML
<RoomType>
	<RoomID>997</RoomID>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>1</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>4896.8</SubTotal>
	<Total>5565.35</Total>
	$roomsAppliesToSerialize
</RoomType>
XML;

		$unserialize = <<<XML
<RoomType>
	<RoomID>997</RoomID>
	<PropertyRoomTypeID/>
	<MealBasisID>1</MealBasisID>
	<Name>Example Villa</Name>
	<View>Sea View</View>
	<Adults>1</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>4896.8</SubTotal>
	<Total>5565.35</Total>
	$roomsAppliesToUnserialize
</RoomType>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}


	public function getRoomType1()
    {
		list($roomsAppliesToInstance, 	$roomsAppliesToSerialize, 	$roomsAppliesToUnserialize) 	= $this->getRoomsAppliesTo();
		list($oneSupplementsInstance, 	$oneSupplementsSerialize, 	$oneSupplementsUnserialize)		= $this->getOneSupplements($this->getSupplement1());
		list($oneSpecialOffertInstance,	$oneSpecialOffertSerialize, $onepecialOffertUnserialize)	= $this->getOneSpecialOffers($this->getSpecialOffer1());
		list($oneTaxesInstance, 		$oneTaxesSerialize, 		$oneTaxesUnserialize) 			= $this->getOneTaxes($this->getTax1());
		list($oneCancellationsInstance,	$oneCancellationsSerialize,	$oneCancellationsUnserialize)	= $this->getOneCancellationPolicies($this->getCancellationPolicy1());

        $instance = new RoomType(
            998,
            null,
            null,
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
			$oneSpecialOffertInstance,
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
	<Children>2</Children>
	<Infants>1</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>5896.8</SubTotal>
	<Total>6565.35</Total>
	$roomsAppliesToSerialize
	$oneSupplementsSerialize
	$oneSpecialOffertSerialize
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
	<Children>2</Children>
	<Infants>1</Infants>
	<OnRequest>True</OnRequest>
	<SubTotal>5896.8</SubTotal>
	<Total>6565.35</Total>
	$roomsAppliesToUnserialize
	$oneSupplementsUnserialize
	$onepecialOffertUnserialize
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

    protected function getRoomType2() : array
    {
		list($twoSupplementsInstance, 		$twoSupplementsSerialize, 		$twoSupplementsUnserialize)		= $this->getTwoSupplements($this->getSupplement1(), $this->getSupplement2());
		list($twoSpecialOffertsInstance,	$twoSpecialOffertsSerialize,	$twoSpecialOffertsUnserialize)	= $this->getTwoSpecialOffers($this->getSpecialOffer1(), $this->getSpecialOffer2());
		list($twoTaxesInstance, 			$twoTaxesSerialize, 			$twoTaxesUnserialize) 			= $this->getFourTaxes($this->getTax1(), $this->getTax2());
		list($twoCancellationsInstance, 	$twoCancellationsSerialize, 	$twoCancellationsUnserialize) 	= $this->getTwoCancellationPolicies($this->getCancellationPolicy1(), $this->getCancellationPolicy2());

        $instance = new RoomType(
            999,
            'RATECODE',
            2,
            1,
            'Example Villa',
            'Sea View',
            2,
            0,
            0,
            true,
            3960,
            4400,
            new RoomsAppliesTo(3),
			$twoSupplementsInstance,
			$twoSpecialOffertsInstance,
			$twoTaxesInstance,
			$twoCancellationsInstance,
        );

        $serialize = <<<XML
<RoomType>
	<RoomID>999</RoomID>
	<RateCode>RATECODE</RateCode>
	<PropertyRoomTypeID>2</PropertyRoomTypeID>
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
		<RoomRequest>3</RoomRequest>
	</RoomsAppliesTo>
	$twoSupplementsSerialize
	$twoSpecialOffertsSerialize
	$twoTaxesSerialize
	$twoCancellationsSerialize
</RoomType>
XML;

        $unserialize = <<<XML
<RoomType>
	<RoomID>999</RoomID>
	<RateCode>RATECODE</RateCode>
	<PropertyRoomTypeID>2</PropertyRoomTypeID>
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
		<RoomRequest>3</RoomRequest>
	</RoomsAppliesTo>
	$twoSupplementsUnserialize
	$twoSpecialOffertsUnserialize
	$twoTaxesUnserialize
	$twoCancellationsUnserialize
</RoomType>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getOneRoomTypes(array $roomType) : array
    {
		list($instance, $serialize, $unserialize) = $roomType;

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

    protected function getTwoRoomTypes(array $roomType1, array $roomType2) : array
    {
		$instance = $serialize = $unserialize = [];
		list($instance[0], $serialize[0], $unserialize[0]) = $roomType1;
		list($instance[1], $serialize[1], $unserialize[1]) = $roomType2;

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