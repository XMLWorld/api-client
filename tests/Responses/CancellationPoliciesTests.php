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
    public function testCancellationPolicy()
    {
        $cancellationPolicy = new CancellationPolicy(
            '2020-07-11',
            574.28
        );

        $this->serialize(
            '<CancellationPolicy>
				<CancelBy>2020-07-11</CancelBy>
				<Penalty>574.28</Penalty>
			</CancellationPolicy>',
            $cancellationPolicy
        );

        $this->unserialize(
            '<CancellationPolicy>
                <Penalty>574.28</Penalty>
				<CancelBy>2020-07-11</CancelBy>
			</CancellationPolicy>',
            $cancellationPolicy
        );

        return $cancellationPolicy;
    }

    /**
     * @depends testCancellationPolicy
     */
    public function testOneCancellationPolicies($cancellationPolicy)
    {
        $oneCancellationPolicy = new CancellationPolicies($cancellationPolicy);

        $this->serialize(
            '<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
            $oneCancellationPolicy
        );

        $this->unserialize(
            '<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
            $oneCancellationPolicy
        );

        return $oneCancellationPolicy;
    }

    /**
     * @depends testCancellationPolicy
     */
    public function testCancellationPolicies($cancellationPolicy)
    {
        $cancellationPolicies = new CancellationPolicies(
            $cancellationPolicy,
            new CancellationPolicy(
                '2020-07-18',
                1148.55
            )
        );

        $this->serialize(
            '<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
				<CancellationPolicy>
					<CancelBy>2020-07-18</CancelBy>
					<Penalty>1148.55</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
            $cancellationPolicies
        );

        $this->unserialize(
            '<CancellationPolicies>
				<CancellationPolicy>
					<Penalty>574.28</Penalty>
					<CancelBy>2020-07-11</CancelBy>
				</CancellationPolicy>
				<CancellationPolicy>
					<CancelBy>2020-07-18</CancelBy>
					<Penalty>1148.55</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
            $cancellationPolicies
        );

        return $cancellationPolicies;
    }
}