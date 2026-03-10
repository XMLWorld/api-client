<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ErrataTest extends BaseSerializeXML
{
	use ErrataTrait;

	#[Test]
    public function erratum1() : array
    {
		list($instance, , ) = $details = $this->getErratum1();

		$this->assertSame('2020-08-04', $instance->startDate);
		$this->assertSame('2020-08-11', $instance->endDate);
		$this->assertSame('Small pool will be closed for maintenance', $instance->description);
		$this->assertNull($instance->additionalCharge);
		$this->assertNull($instance->amount);
		$this->assertNull($instance->currency);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function erratum2() : array
	{
		list($instance, , ) = $details = $this->getErratum2();

		$this->assertSame('2020-08-04', $instance->startDate);
		$this->assertSame('2020-08-11', $instance->endDate);
		$this->assertSame('There won\'t be mayonese at the restaurant', $instance->description);
		$this->assertNull($instance->additionalCharge);
		$this->assertNull($instance->amount);
		$this->assertNull($instance->currency);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function erratum3() : array
	{
		list($instance, , ) = $details = $this->getErratum3();

		$this->assertSame('2020-08-04', $instance->startDate);
		$this->assertSame('2020-08-11', $instance->endDate);
		$this->assertSame('some fees', $instance->description);
		$this->assertTrue($instance->additionalCharge);
		$this->assertSame(10.0, $instance->amount);
		$this->assertSame('USD', $instance->currency);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('erratum1')]
    public function oneErrata(array $erratum) : array
    {
		list($erratumInstance, , ) = $erratum;

		list($instance, , ) = $details = $this->getOneErrata($erratum);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($erratumInstance, $instance[0]);
		$this->assertSame(
			[$erratumInstance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('erratum1')]
	#[Depends('erratum2')]
    public function twoErrata(array $erratum1, array $erratum2) : array
    {
		list($erratum1Instance, , ) = $erratum1;
		list($erratum2Instance, , ) = $erratum2;

		list($instance, , ) = $details = $this->getTwoErrata($erratum1, $erratum2);

		$this->assertCount(2, $instance, 'it has two elements');

		$this->assertSame($erratum1Instance, $instance[0]);
		$this->assertSame($erratum2Instance, $instance[1]);

		$this->assertSame(
			[$erratum1Instance, $erratum2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}