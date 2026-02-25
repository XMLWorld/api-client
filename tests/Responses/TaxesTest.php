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
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class TaxesTest extends BaseSerializeXML
{
	use TaxesTrait;

    public function testTax()
    {
		$details = $this->getTax();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneTaxes()
    {
		$details = $this->getOneTaxes();

		$this->doTest(...$details);

		return $details;
    }

    public function testTaxes()
    {
		$details = $this->getTaxes();

		$this->doTest(...$details);

		return $details;
    }
}