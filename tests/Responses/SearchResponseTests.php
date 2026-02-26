<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SearchResponseTests extends BaseSerializeXML
{
	use SearchResponseTrait;

    public function testSearchResponseOneProperty()
    {
		$details = $this->getSearchResponseOneProperty();

		$this->doTest(...$details);

		return $details;
    }
}