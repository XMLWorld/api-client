<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class GuestsTests extends BaseSerializeXML
{
	use GuestsTrait;

    public function testAdultGuest()
    {
        $details = $this->getAdultGuest();

		$this->doTest(...$details);

		return $details;
    }

    public function testChildGuest()
    {
		$details = $this->getChildGuest();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneGuests()
    {
		$details = $this->getOneGuests();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoGuests()
    {
        $details = $this->getTwoGuests();

		$this->doTest(...$details);

		return $details;
    }
}