<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\SearchResponse;

class SearchResponseTests extends PropertyResultTests
{
	use SearchResponseTrait;

    public function testSearchResponseOneProperty()
    {
		$details = $this->getSearchResponseOneProperty();

		$this->doTest(...$details);

		return $details;
    }
}