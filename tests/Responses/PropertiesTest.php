<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
	use PropertiesTrait;

	#[Test]
    public function minProperty() : array
    {
		list($instance, , ) = $details = $this->getMinProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function sympleProperty() : array
    {
		list($instance, , ) = $details = $this->getSympleProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function complexProperty() : array
    {
		list($instance, , ) = $details = $this->getComplexProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}