<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SpecialOffersTest extends BaseSerializeXML
{
	use SpecialOffersTrait;

	#[Test]
    public function specialOffer1() : array
    {
		list($instance, , ) = $details = $this->getSpecialOffer1();

		$this->assertSame('Example special offer', $instance->name, 'name is correct');
		$this->assertSame('Value Added', $instance->type, 'type is correct');
		$this->assertNull($instance->value, 'value is correct');
		$this->assertNull($instance->paxType, 'paxType is correct');
		$this->assertNull($instance->total, 'total is correct');
		$this->assertSame('test desc', $instance->desc, 'type is correct');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function specialOffer2()
    {
		list($instance, , ) = $details = $this->getSpecialOffer2();

		$this->assertSame('Example special offer 2', $instance->name, 'name is correct');
		$this->assertSame('Free Kids', $instance->type, 'type is correct');
		$this->assertSame(1.0, $instance->value, 'value is correct');
		$this->assertNull($instance->paxType, 'paxType is correct');
		$this->assertSame(1000.0, $instance->total, 'total is correct');
		$this->assertSame('test desc', $instance->desc, 'type is correct');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function specialOffer3()
	{
		list($instance, , ) = $details = $this->getSpecialOffer3();

		$this->assertSame('Early Bird Booking', $instance->name, 'name is correct');
		$this->assertSame('Adult Only', $instance->type, 'type is correct');
		$this->assertSame(10.0, $instance->value, 'value is correct');
		$this->assertSame('All', $instance->paxType, 'paxType is correct');
		$this->assertSame(440.0, $instance->total, 'total is correct');

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('specialOffer1')]
    public function oneSpecialOffer(array $specialOffer1) : array
    {
		list($specialOffer1Instance, , ) = $specialOffer1;

		list($instance, , ) = $details = $this->getOneSpecialOffers($specialOffer1);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($specialOffer1Instance, $instance[0]);
		$this->assertSame(
			[$specialOffer1Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('specialOffer1')]
	#[Depends('specialOffer2')]
    public function twoSpecialOffers(array $specialOffer1, array $specialOffer2) : array
    {
		list($specialOffer1Instance, , ) = $specialOffer1;
		list($specialOffer2Instance, , ) = $specialOffer2;

		list($instance, , ) = $details = $this->getTwoSpecialOffers($specialOffer1, $specialOffer2);

		$this->assertCount(2, $instance, 'it has two elements');
		$this->assertSame($specialOffer1Instance, $instance[0]);
		$this->assertSame($specialOffer2Instance, $instance[1]);
		$this->assertSame(
			[$specialOffer1Instance, $specialOffer2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}