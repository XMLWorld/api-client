<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class CancelResponseTest extends BaseSerializeXML
{
	use CancelResponseTrait;

	#[Test]
    public function cancelResponse() : array
    {
		list($instance, , ) = $details = $this->getCancelResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function failedCancelResponse() : array
	{
		list($instance, , ) = $details = $this->getFailedCancelResponse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}