<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertyResultTests extends BaseSerializeXML
{
	use PropertyResultTrait;

    public function testPropertyResult()
    {
		$details = $this->getPropertyResult();

		$this->doTest(...$details);

		return $details;
    }

    public function testOnePropertyResult()
    {
		$details = $this->getOnePropertyResult();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoPropertyResults()
    {
		$details = $this->getTwoPropertyResults();

		$this->doTest(...$details);

		return $details;
    }
}