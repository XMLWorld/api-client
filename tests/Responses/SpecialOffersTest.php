<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SpecialOffersTest extends BaseSerializeXML
{
    public function testSpecialOffer1()
    {
        $specialOffer1 = new SpecialOffer(
            'Example special offer',
            'Value Added',
            null,
            null,
            null,
            'test desc'
        );

        $this->serialize(
            '<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>',
            $specialOffer1
        );

        $this->unserialize(
            '<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>',
            $specialOffer1
        );

        return $specialOffer1;
    }

    public function testSpecialOffer2()
    {
        $specialOffer2 = new SpecialOffer(
            'Example special offer 2',
            'Free Kids',
            1,
            null,
            1000,
            'test desc'
        );

        $this->serialize(
            '<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Type>Free Kids</Type>
				<Value>1</Value>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>',
            $specialOffer2
        );

        $this->unserialize(
            '<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Value>1</Value>
				<Type>Free Kids</Type>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>',
            $specialOffer2
        );

        return $specialOffer2;
    }

    /**
     * @depends testSpecialOffer1
     */
    public function testOneSpecialOffer($specialOffer1)
    {
        $oneSpecialOffer = new SpecialOffers($specialOffer1);

        $this->serialize(
            '<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
            $oneSpecialOffer
        );

        $this->unserialize(
            '<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
            $oneSpecialOffer
        );

        return $oneSpecialOffer;
    }

    /**
     * @depends testSpecialOffer1
     * @depends testSpecialOffer2
     */
    public function testTwoSpecialOffers($specialOffer1, $specialOffer2)
    {
        $twoSpecialOffers = new SpecialOffers(
            $specialOffer1,
            $specialOffer2
        );

        $this->serialize(
            '<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
				<SpecialOffer>
					<Name>Example special offer 2</Name>
					<Type>Free Kids</Type>
					<Value>1</Value>
					<Total>1000</Total>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
            $twoSpecialOffers
        );

        $this->unserialize(
            '<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
				<SpecialOffer>
					<Name>Example special offer 2</Name>
					<Type>Free Kids</Type>
					<Value>1</Value>
					<Total>1000</Total>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
            $twoSpecialOffers
        );

        return $twoSpecialOffers;
    }

}