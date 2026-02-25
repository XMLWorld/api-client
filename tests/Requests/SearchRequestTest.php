<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchRequestTest extends BaseSerializeXML
{
	use SearchRequestTrait;

	public function testSearchRequestOneProperty()
	{
		$details = $this->getSearchRequestOneProperty();

		$this->doTest(...$details);

		return $details;
	}
	public function testSearchRequestTwoProperties()
	{
		$details = $this->getSearchRequestTwoProperties();

		$this->doTest(...$details);

		return $details;
	}
}