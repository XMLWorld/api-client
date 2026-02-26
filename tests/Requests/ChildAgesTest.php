<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ChildAgesTest extends BaseSerializeXML
{
    use ChildAgesTrait;

	public function testChildAge()
	{
		$details = $this->getChildAge();

		$this->doTest(...$details);

		return $details;
	}

	public function testOneChildAges()
	{
		$details = $this->getOneChildAges();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoChildAges()
	{
		$details = $this->getTwoChildAges();

		$this->doTest(...$details);

		return $details;
	}
}