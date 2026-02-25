<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;
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