<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ResponseTest extends BaseSerializeXML
{
	use ResponseTrait;

	#[Test]
    public function responseInfo() : array
    {
		$details = $this->getResponseInfo();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function returnStatusTrue() : array
    {
		$details = $this->getReturnStatusTrue();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function couldNotFindRoomsStatus() : array
	{
		list($instance, , ) = $details = $this->getCouldNotFindRoomsStatus();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function priceDoesNotMatchStatus() : array
	{
		list($instance, , ) = $details = $this->getPriceDoesNotMatchStatus();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
    public function returnStatusFalse() : array
    {
		list($instance, , ) = $details = $this->getReturnStatusFalse();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function noResponseFromSupplier() : array
	{
		list($instance, , ) = $details = $this->getNoResponseFromSupplier();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}