<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookResponseTest extends BaseSerializeXML
{
	use BookResponseTrait;

	#[Test]
    public function bookResponse() : array
    {
		list($instance, , ) = $details = $this->getBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function failedBookResponse() : array
	{
		list($instance, , ) = $details = $this->getFailedBookResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}