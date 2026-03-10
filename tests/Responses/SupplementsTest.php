<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SupplementsTest extends BaseSerializeXML
{
	use SupplementsTrait;

	#[Test]
    public function supplement1() : array
    {
		list($instance, , ) = $details = $this->getSupplement1();

		$this->assertSame('Weekend Stay (Fri - Sun)', $instance->name);
		$this->assertSame('Per Night', $instance->duration);
		$this->assertSame('Per Room', $instance->multiplier);
		$this->assertSame(60.0, $instance->total);
		$this->assertNull($instance->paxType);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function supplement2() : array
    {
		list($instance, , ) = $details = $this->getSupplement2();

		$this->assertSame('test supplement', $instance->name);
		$this->assertSame('Per Night', $instance->duration);
		$this->assertSame('Per Person', $instance->multiplier);
		$this->assertSame(220.0, $instance->total);
		$this->assertSame('Adult Only', $instance->paxType);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('supplement1')]
    public function oneSupplements($supplement1) : array
    {
		list($supplement1Instance, , ) = $supplement1;
		list($instance, , ) = $details = $this->getOneSupplements($supplement1);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($supplement1Instance, $instance[0]);
		$this->assertSame(
			[$supplement1Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('supplement1')]
	#[Depends('supplement2')]
    public function testTwoSupplements(array $supplement1, array $supplement2) : array
    {
		list($supplement1Instance, , ) = $supplement1;
		list($supplement2Instance, , ) = $supplement2;
		list($instance, , ) = $details = $this->getTwoSupplements($supplement1, $supplement2);

		$this->assertCount(2, $instance, 'it has two elements');
		$this->assertSame($supplement1Instance, $instance[0]);
		$this->assertSame($supplement2Instance, $instance[1]);
		$this->assertSame(
			[$supplement1Instance, $supplement2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}