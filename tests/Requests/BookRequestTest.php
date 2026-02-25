<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookRequestTest extends BaseSerializeXML
{
	use BookRequestTrait;

    public function testBookRequest()
    {
		$details = $this->getBookRequest();

		$this->doTest(...$details);

		return $details;
    }
}