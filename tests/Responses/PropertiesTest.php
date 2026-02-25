<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
	use PropertiesTrait;

    public function testMinProperty()
    {
		$details = $this->getMinProperty();

		$this->doTest(...$details);

		return $details;
    }

    public function testSympleProperty()
    {
		$details = $this->getSympleProperty();

		$this->doTest(...$details);

		return $details;
    }

    public function testComplexProperty()
    {
		$details = $this->getComplexProperty();

		$this->doTest(...$details);

		return $details;
    }
}