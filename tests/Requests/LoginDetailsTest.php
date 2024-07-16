<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LoginDetailsTest extends BaseSerializeXML
{
    public function testLoginDetails()
    {
        $loginDetails = new LoginDetails('login', 'pass', 'version');

        $this->serialize(
            '<LoginDetails>
				<Login>login</Login>
				<Password>pass</Password>
				<Version>version</Version>
			</LoginDetails>',
            $loginDetails
        );

        $this->unserialize(
            '<LoginDetails>
				<Login>login</Login>
				<Password>pass</Password>
				<Version>version</Version>
			</LoginDetails>',
            $loginDetails
        );

        return $loginDetails;
    }
}