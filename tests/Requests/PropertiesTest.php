<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
    use PropertiesTrait;

	#[Test]
	public function oneProperty() : array
	{
		list($instance, , ) = $details = $this->getOneProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function twoProperties() : array
	{
		list($instance, , ) = $details = $this->getTwoProperties();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}