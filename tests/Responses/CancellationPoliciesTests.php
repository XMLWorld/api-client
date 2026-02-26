<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class CancellationPoliciesTests extends BaseSerializeXML
{
	use CancellationPoliciesTrait;

    public function testCancellationPolicy()
    {
		$details = $this->getCancellationPolicy();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneCancellationPolicies()
    {
		$details = $this->getOneCancellationPolicies();

		$this->doTest(...$details);

		return $details;
    }

    public function testCancellationPolicies()
    {
		$details = $this->getCancellationPolicies();

		$this->doTest(...$details);

		return $details;
    }
}