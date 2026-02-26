<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LeadGuestsTests extends BaseSerializeXML
{
	use LeadGuestsTrait;

    public function testAdultLeadGuest()
    {
		$details = $this->getAdultLeadGuest();

		$this->doTest(...$details);

		return $details;
    }
}