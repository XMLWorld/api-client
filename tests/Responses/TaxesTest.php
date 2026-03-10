<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class TaxesTest extends BaseSerializeXML
{
	use TaxesTrait;

	#[Test]
    public function tax1() : array
    {
		list($instance, , ) = $details = $this->getTax1();

		$this->assertSame('test %', $instance->taxName, 'taxName is correct');
		$this->assertFalse($instance->inclusive, 'inclusive is correct');
		$this->assertSame(1148.55, $instance->total, 'total is correct');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function tax2() : array
	{
		list($instance, , ) = $details = $this->getTax2();

		$this->assertSame('Government Tax', $instance->taxName, 'taxName is correct');
		$this->assertTrue($instance->inclusive, 'inclusive is correct');
		$this->assertSame(423.15, $instance->total, 'total is correct');

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('tax1')]
    public function oneTaxes(array $tax1) : array
    {
		list($tax1Instance, , ) = $tax1;

		list($instance, , ) = $details = $this->getOneTaxes($tax1);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($tax1Instance, $instance[0]);
		$this->assertSame(
			[$tax1Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('tax1')]
	#[Depends('tax2')]
    public function twoTaxes(array $tax1, array $tax2)
    {
		list($tax1Instance, , ) = $tax1;
		list($tax2Instance, , ) = $tax2;

		list($instance, , ) = $details = $this->getFourTaxes($tax1, $tax2);

		$this->assertCount(4, $instance, 'it has two elements');
		$this->assertSame($tax1Instance, $instance[0]);
		$this->assertSame($tax2Instance, $instance[1]);
		$this->assertSame(
			[$tax1Instance, $tax2Instance, $instance[2], $instance[3]],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}