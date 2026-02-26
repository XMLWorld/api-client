<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class CancellationPoliciesTests extends BaseSerializeXML
{
	use CancellationPoliciesTrait;

	#[Test]
    public function cancellationPolicy1() : array
    {
		list($instance, , ) = $details = $this->getCancellationPolicy1();

		$this->assertSame('2020-07-11', $instance->cancelBy, 'cancelBy is correct');
		$this->assertSame(574.28, $instance->penalty, 'penalty is correct');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function cancellationPolicy2() : array
	{
		list($instance, , ) = $details = $this->getCancellationPolicy2();

		$this->assertSame('2020-07-18', $instance->cancelBy, 'cancelBy is correct');
		$this->assertSame(1148.55, $instance->penalty, 'penalty is correct');

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('cancellationPolicy1')]
    public function oneCancellationPolicies(array $cancellationPolicy) : array
    {
		list($cancellationPolicyInstance, , ) = $cancellationPolicy;

		list($instance, , ) = $details = $this->getOneCancellationPolicies($cancellationPolicy);

		$this->assertCount(1, $instance, 'it only has one element');
		$this->assertSame($cancellationPolicyInstance, $instance[0]);
		$this->assertSame(
			[$cancellationPolicyInstance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('cancellationPolicy1')]
	#[Depends('cancellationPolicy2')]
    public function twoCancellationPolicies(array $cancellationPolicy1, array $cancellationPolicy2) : array
    {
		list($cancellationPolicy1Instance, , ) = $cancellationPolicy1;
		list($cancellationPolicy2Instance, , ) = $cancellationPolicy2;

		list($instance, , ) = $details = $this->getTwoCancellationPolicies($cancellationPolicy1, $cancellationPolicy2);

		$this->assertCount(2, $instance, 'it has two elements');

		$this->assertSame($cancellationPolicy1Instance, $instance[0]);
		$this->assertSame($cancellationPolicy2Instance, $instance[1]);

		$this->assertSame(
			[$cancellationPolicy1Instance, $cancellationPolicy2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}