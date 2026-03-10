<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class CancelRequestTest extends BaseSerializeXML
{
	use CancelRequestTrait;

	#[Test]
    public function bookingUpdateRequest() : array
    {
		list($instance, , ) = $details = $this->getCancellationRequest();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}