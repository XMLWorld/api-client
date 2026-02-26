<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ChildAgesTest extends BaseSerializeXML
{
    use ChildAgesTrait;

	#[Test]
	public function childAge() : array
	{
		list($instance, , ) = $details = $this->getChildAge();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function oneChildAges() : array
	{
		list($instance, , ) = $details = $this->getOneChildAges();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function twoChildAges() : array
	{
		$details = $this->getTwoChildAges();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}