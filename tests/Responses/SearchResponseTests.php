<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchResponseTests extends BaseSerializeXML
{
	use SearchResponseTrait;

	#[Test]
    public function searchResponseOneProperty()
    {
		list($instance, , ) = $details = $this->getSearchResponseOneProperty();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function searchResponseTwoProperties()
	{
		list($instance, , ) = $details = $this->getSearchResponseTwoProperties();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}