<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;

trait CancellationPoliciesTrait
{
    protected function getCancellationPolicy()
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

	protected function getOneCancellationPolicies()
    {
		list($instance, $serialize, $unserialize) = $this->getCancellationPolicy();

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

    /**
     * @depends testCancellationPolicy
     */
	protected function getCancellationPolicies()
    {
		list($instance, $serialize, $unserialize) = $this->getCancellationPolicy();

		$instance = new CancellationPolicies(
			$instance,
            new CancellationPolicy(
                '2020-07-18',
                1148.55
            )
        );

        $serialize = <<<XML
<CancellationPolicies>
	$serialize
	<CancellationPolicy>
		<CancelBy>2020-07-18</CancelBy>
		<Penalty>1148.55</Penalty>
	</CancellationPolicy>
</CancellationPolicies>
XML;

        $unserialize = <<<XML
<CancellationPolicies>
	$unserialize
	<CancellationPolicy>
		<CancelBy>2020-07-18</CancelBy>
		<Penalty>1148.55</Penalty>
	</CancellationPolicy>
</CancellationPolicies>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}