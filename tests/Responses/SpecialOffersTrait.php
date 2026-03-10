<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;

trait SpecialOffersTrait
{
    protected function getSpecialOffer1() : array
    {
        $instance = new SpecialOffer(
            'Example special offer',
            'Value Added',
            null,
            null,
            null,
            'test desc'
        );

        $serialize = <<<'XML'
<SpecialOffer>
	<Name>Example special offer</Name>
	<Type>Value Added</Type>
	<Desc>test desc</Desc>
</SpecialOffer>
XML;

        $unSerialize = <<<'XML'
<SpecialOffer>
	<Name>Example special offer</Name>
	<Type>Value Added</Type>
	<Desc>test desc</Desc>
</SpecialOffer>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }

	protected function getSpecialOffer2() : array
    {
        $instance = new SpecialOffer(
            'Example special offer 2',
            'Free Kids',
            1,
            null,
            1000,
            'test desc'
        );

        $serialize = <<<'XML'
<SpecialOffer>
	<Name>Example special offer 2</Name>
	<Type>Free Kids</Type>
	<Value>1</Value>
	<Total>1000</Total>
	<Desc>test desc</Desc>
</SpecialOffer>
XML;

        $unSerialize = <<<'XML'
<SpecialOffer>
	<Name>Example special offer 2</Name>
	<Value>1</Value>
	<Type>Free Kids</Type>
	<Total>1000</Total>
	<Desc>test desc</Desc>
</SpecialOffer>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }

	public function getSpecialOffer3() : array
	{
		$instance = new SpecialOffer(
			'Early Bird Booking',
			'Adult Only',
			10,
			'All',
			440
		);

		$serialize = <<<'XML'
<SpecialOffer>
	<Name>Early Bird Booking</Name>
	<Type>Adult Only</Type>
	<Value>10</Value>
	<PaxType>All</PaxType>
	<Total>440</Total>
</SpecialOffer>
XML;

		$unSerialize = <<<'XML'
<SpecialOffer>
	<Name>Early Bird Booking</Name>
	<Type>Adult Only</Type>
	<Value>10</Value>
	<PaxType>All</PaxType>
	<Total>440</Total>
</SpecialOffer>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
	}

    public function getOneSpecialOffers(array $specialOffer1) : array
    {
        list($instance, $serialize, $unserialize) = $specialOffer1;

        $instance = new SpecialOffers($instance);

		$serialize = <<<XML
<SpecialOffers>
	$serialize
</SpecialOffers>
XML;

		$unSerialize = <<<XML
<SpecialOffers>
	$unserialize
</SpecialOffers>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
    }

    protected function getTwoSpecialOffers(array $specialOffer1, array $specialOffer2) : array
    {
        $instances = $serializes = $unserializes = [];
        list($instances[], $serializes[0], $unserializes[0]) = $specialOffer1;
        list($instances[], $serializes[1], $unserializes[1]) = $specialOffer2;

        $instance = new SpecialOffers(...$instances);

		$serialize = <<<XML
<SpecialOffers>
	$serializes[0]
	$serializes[1]
</SpecialOffers>
XML;

		$unSerialize = <<<XML
<SpecialOffers>
	$unserializes[0]
	$unserializes[1]
</SpecialOffers>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
    }
}