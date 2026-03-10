<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LoginDetailsTest extends BaseSerializeXML
{
    use LoginDetailsTrait;

	#[Test]
	public function loginDetails() : array
	{
		list($instance, , ) = $details = $this->getLoginDetails();

		$this->assertSame('login', $instance->login);
		$this->assertSame('pass', $instance->password);
		$this->assertSame('version', $instance->version);

		$this->doTest(...$details);

		return $details;
	}
}