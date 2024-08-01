<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

trait LoginDetailsTrait
{
    public function testLoginDetails()
    {
        $instance = new LoginDetails('login', 'pass', 'version');

        $serialize = '<LoginDetails>
				<Login>login</Login>
				<Password>pass</Password>
				<Version>version</Version>
			</LoginDetails>';

        $unserialize = '<LoginDetails>
                <Password>pass</Password>
				<Login>login</Login>
				<Version>version</Version>
			</LoginDetails>';

        $loginDetails = [
            $instance,
            $serialize,
            $unserialize
        ];

        $this->doTest(...$loginDetails);

        return $loginDetails;
    }
}