<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\LeadGuest;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LeadGuestsTests extends BaseSerializeXML
{
	use LeadGuestsTrait;

    public function testAdultGuest()
    {
		$details = $this->getAdultGuest();

		$this->doTest(...$details);

		return $details;
    }
}