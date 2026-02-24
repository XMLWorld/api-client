<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\LoginDetails;

trait LoginDetailsTrait
{
    public function testLoginDetails()
    {
        $instance = new LoginDetails('login', 'pass', 'version');

        $serialize = <<<'XML'
<LoginDetails>
	<Login>login</Login>
	<Password>pass</Password>
	<Version>version</Version>
</LoginDetails>
XML;

        $unserialize = <<<'XML'
<LoginDetails>
	<Password>pass</Password>
	<Login>login</Login>
	<Version>version</Version>
</LoginDetails>
XML;

		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

		return $details;
    }
}