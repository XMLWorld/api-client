<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
    use PropertiesTrait;

	public function testOneProperty()
	{
		$details = $this->getOneProperty();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoProperties()
	{
		$details = $this->getTwoProperties();

		$this->doTest(...$details);

		return $details;
	}
}