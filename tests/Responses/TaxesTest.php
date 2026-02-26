<?php

namespace XMLWorld\ApiClient\Test\Responses;

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