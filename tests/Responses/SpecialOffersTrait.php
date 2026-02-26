<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;

trait SpecialOffersTrait
{
    protected function getSpecialOffer1()
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

	protected function getSpecialOffer2()
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

    public function getOneSpecialOffers()
    {
        list($instance, $serialize, $unserialize) = $this->getSpecialOffer1();

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

    protected function getTwoSpecialOffers()
    {
        $instances = $serializes = $unserializes = [];
        list($instances[], $serializes[0], $unserializes[0]) = $this->getSpecialOffer1();
        list($instances[], $serializes[1], $unserializes[1]) = $this->getSpecialOffer2();

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