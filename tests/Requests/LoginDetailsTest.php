<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LoginDetailsTest extends BaseSerializeXML
{
    use LoginDetailsTrait;

	public function testLoginDetails()
	{
		$details = $this->getLoginDetails();

		$this->doTest(...$details);

		return $details;
	}
}