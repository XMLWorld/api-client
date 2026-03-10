<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookRequestTest extends BaseSerializeXML
{
	use BookRequestTrait;

	#[Test]
    public function bookRequest() : array
    {
		list($instance, , ) = $details = $this->getBookRequest();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}