<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomTypesTests extends BaseSerializeXML
{
	use RoomTypesTrait;

	#[Test]
	public function roomType0() : array
	{
		list($roomType, , ) = $details = $this->getRoomType0();

		$this->assertSame(997, $roomType->roomID);
		$this->assertNull($roomType->rateCode);
		$this->assertNull($roomType->propertyRoomTypeID);
		$this->assertSame(1, $roomType->mealBasisID);
		$this->assertSame('Example Villa', $roomType->name);
		$this->assertSame('Sea View', $roomType->view);

		$this->assertSame(1, $roomType->adults);
		$this->assertSame(0, $roomType->children);
		$this->assertSame(0, $roomType->infants);

		$this->assertTrue($roomType->onRequest);

		$this->assertSame(4896.80, $roomType->subTotal);
		$this->assertSame(5565.35, $roomType->total);

		$this->assertIsArray($roomType->roomsAppliesTo->roomRequest);
		$this->assertCount(1, $roomType->roomsAppliesTo->roomRequest);
		$this->assertSame(1, $roomType->roomsAppliesTo->roomRequest[0]);

		$this->assertNull($roomType->supplements);
		$this->assertNull($roomType->specialOffers);
		$this->assertNull($roomType->taxes);
		$this->assertNull($roomType->cancellationPolicies);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
    public function roomType1() : array
    {
		list($roomType, , ) = $details = $this->getRoomType1();

		$this->assertSame(998, $roomType->roomID);
		$this->assertNull($roomType->rateCode);
		$this->assertNull($roomType->propertyRoomTypeID);
		$this->assertSame(1, $roomType->mealBasisID);
		$this->assertSame('Example Villa', $roomType->name);
		$this->assertSame('Sea View', $roomType->view);

		$this->assertSame(2, $roomType->adults);
		$this->assertSame(2, $roomType->children);
		$this->assertSame(1, $roomType->infants);

		$this->assertTrue($roomType->onRequest);

		$this->assertSame(5896.80, $roomType->subTotal);
		$this->assertSame(6565.35, $roomType->total);

		$this->assertIsArray($roomType->roomsAppliesTo->roomRequest);
		$this->assertCount(1, $roomType->roomsAppliesTo->roomRequest);
		$this->assertSame(1, $roomType->roomsAppliesTo->roomRequest[0]);

		$this->assertCount(1, $roomType->supplements);
		$this->assertCount(1, $roomType->specialOffers);
		$this->assertCount(1, $roomType->taxes);
		$this->assertCount(1, $roomType->cancellationPolicies);


		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function roomType2() : array
    {
		list($roomType, , ) = $details = $this->getRoomType2();

		$this->assertSame(999, $roomType->roomID);
		$this->assertSame('RATECODE', $roomType->rateCode);
		$this->assertSame(2, $roomType->propertyRoomTypeID);
		$this->assertSame(1, $roomType->mealBasisID);
		$this->assertSame('Example Villa', $roomType->name);
		$this->assertSame('Sea View', $roomType->view);

		$this->assertSame(2, $roomType->adults);
		$this->assertSame(0, $roomType->children);
		$this->assertSame(0, $roomType->infants);

		$this->assertTrue($roomType->onRequest);

		$this->assertSame(3960.0, $roomType->subTotal);
		$this->assertSame(4400.0, $roomType->total);

		$this->assertIsArray($roomType->roomsAppliesTo->roomRequest);
		$this->assertCount(1, $roomType->roomsAppliesTo->roomRequest);
		$this->assertSame(3, $roomType->roomsAppliesTo->roomRequest[0]);

		$this->assertCount(2, $roomType->supplements);
		$this->assertCount(2, $roomType->specialOffers);
		$this->assertCount(4, $roomType->taxes);
		$this->assertCount(2, $roomType->cancellationPolicies);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('roomType1')]
    public function oneRoomTypes(array $roomType) : array
    {
		list($roomTypeInstance, , ) = $roomType;

		list($instance, , ) = $details = $this->getOneRoomTypes($roomType);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($roomTypeInstance, $instance[0]);
		$this->assertSame(
			[$roomTypeInstance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('roomType1')]
	#[Depends('roomType2')]
    public function twoRoomTypes(array $roomType1, array $roomType2) : array
    {
		list($roomType1Instance, , ) = $roomType1;
		list($roomType2Instance, , ) = $roomType2;

		list($instance, , ) = $details = $this->getTwoRoomTypes($roomType1, $roomType2);

		$this->assertCount(2, $instance, 'it has two elements');
		$this->assertSame($roomType1Instance, $instance[0]);
		$this->assertSame($roomType2Instance, $instance[1]);
		$this->assertSame(
			[$roomType1Instance, $roomType2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}