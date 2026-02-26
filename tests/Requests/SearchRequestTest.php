<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchRequestTest extends BaseSerializeXML
{
	use SearchRequestTrait;

	#[Test]
	public function searchRequestOneProperty() : array
	{
		list($instance, , ) = $details = $this->getSearchRequestOneProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function searchRequestTwoProperties() : array
	{
		list($instance, , ) = $details = $this->getSearchRequestTwoProperties();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}