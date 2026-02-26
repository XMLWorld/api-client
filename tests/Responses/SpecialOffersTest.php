<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SpecialOffersTest extends BaseSerializeXML
{
	use SpecialOffersTrait;

    public function testSpecialOffer1()
    {
		list($instance, $serialize, $unserialize) = $this->getSpecialOffer1();

		$this->doTest($instance, $serialize, $unserialize);
    }

    public function testSpecialOffer2()
    {
		$details = $this->getSpecialOffer2();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneSpecialOffer()
    {
		$details = $this->getOneSpecialOffers();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoSpecialOffers()
    {
		$details = $this->getTwoSpecialOffers();

		$this->doTest(...$details);

		return $details;
    }

}