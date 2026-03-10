<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;

trait CancellationPoliciesTrait
{
    protected function getCancellationPolicy1() : array
    {
        $instance = new CancellationPolicy(
            '2020-07-11',
            574.28
        );

        $serialize = <<<'XML'
<CancellationPolicy>
	<CancelBy>2020-07-11</CancelBy>
	<Penalty>574.28</Penalty>
</CancellationPolicy>
XML;

        $unserialize = <<<'XML'
<CancellationPolicy>
	<Penalty>574.28</Penalty>
	<CancelBy>2020-07-11</CancelBy>
</CancellationPolicy>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getCancellationPolicy2() : array
	{
		$instance = new CancellationPolicy(
			'2020-07-18',
			1148.55
		);

		$serialize = <<<'XML'
<CancellationPolicy>
	<CancelBy>2020-07-18</CancelBy>
	<Penalty>1148.55</Penalty>
</CancellationPolicy>
XML;

		$unserialize = <<<'XML'
<CancellationPolicy>
	<Penalty>1148.55</Penalty>
	<CancelBy>2020-07-18</CancelBy>
</CancellationPolicy>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getOneCancellationPolicies(array $cancellationPolicy) : array
    {
		list($instance, $serialize, $unserialize) = $cancellationPolicy;

		$instance = new CancellationPolicies($instance);

        $serialize = <<<XML
<CancellationPolicies>
	$serialize
</CancellationPolicies>
XML;

        $unserialize = <<<XML
<CancellationPolicies>
	$unserialize
</CancellationPolicies>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getTwoCancellationPolicies(array $cancellationPolicy1, array $cancellationPolicy2) : array
    {
		list($cancellationPolicy1instance, $cancellationPolicy1Serialize, $cancellationPolicy1Unserialize) = $cancellationPolicy1;
		list($cancellationPolicy2instance, $cancellationPolicy2Serialize, $cancellationPolicy2Unserialize) = $cancellationPolicy2;

		$instance = new CancellationPolicies(
			$cancellationPolicy1instance,
			$cancellationPolicy2instance
        );

        $serialize = <<<XML
<CancellationPolicies>
	$cancellationPolicy1Serialize
	$cancellationPolicy2Serialize
</CancellationPolicies>
XML;

        $unserialize = <<<XML
<CancellationPolicies>
	$cancellationPolicy1Unserialize
	$cancellationPolicy2Unserialize
</CancellationPolicies>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}