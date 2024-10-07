<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
trait SpecialOffersTrait
{
    public function testSpecialOffer1()
    {
        $instance = new SpecialOffer(
            'Example special offer',
            'Value Added',
            null,
            null,
            null,
            'test desc'
        );

        $serialize = '<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>';

        $unSerialize = '<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>';

        $specialOffer1 = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$specialOffer1);

        return $specialOffer1;
    }

    public function testSpecialOffer2()
    {
        $instance = new SpecialOffer(
            'Example special offer 2',
            'Free Kids',
            1,
            null,
            1000,
            'test desc'
        );

        $serialize = '<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Type>Free Kids</Type>
				<Value>1</Value>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>';

        $unSerialize = '<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Value>1</Value>
				<Type>Free Kids</Type>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>';

        $specialOffer2 = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$specialOffer2);

        return $specialOffer2;
    }

    /**
     * @depends testSpecialOffer1
     */
    public function testOneSpecialOffers($specialOffer1)
    {
        list($instance, $serialize, $unserialize) = $specialOffer1;

        $instance = new SpecialOffers($instance);

        $oneSpecialOffer = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$oneSpecialOffer);

        return $oneSpecialOffer;
    }

    /**
     * @depends testSpecialOffer1
     * @depends testSpecialOffer2
     */
    public function testTwoSpecialOffers($specialOffer1, $specialOffer2)
    {
        $instances = $serializes = $unserializes = [];
        list($instances[], $serializes[0], $unserializes[0]) = $specialOffer1;
        list($instances[], $serializes[1], $unserializes[1]) = $specialOffer2;

        $instance = new SpecialOffers(...$instances);

        $twoSpecialOffers = $this->wrap(
            $instance,
            implode(PHP_EOL, $serializes),
            implode(PHP_EOL, $unserializes),
        );

        $this->doTest(...$twoSpecialOffers);

        return $twoSpecialOffers;
    }

}