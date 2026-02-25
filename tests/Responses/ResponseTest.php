<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ResponseTest extends BaseSerializeXML
{
	use ResponseTrait;

    public function testResponseInfo()
    {
		$details = $this->getResponseInfo();

		$this->doTest(...$details);

		return $details;
    }

    public function testReturnStatusTrue()
    {
		$details = $this->getReturnStatusTrue();

		$this->doTest(...$details);

		return $details;
    }

    public function testReturnStatusFalse()
    {
		$details = $this->getReturnStatusFalse();

		$this->doTest(...$details);

		return $details;
    }
}