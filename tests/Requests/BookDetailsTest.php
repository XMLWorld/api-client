<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class BookDetailsTest extends BaseSerializeXML
{
	use BookDetailsTrait;

    public function testOneRoomBookingDetails()
    {
		$details = $this->getOneRoomBookingDetails();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoRoomBookingDetails()
    {
		$details = $this->getTwoRoomBookingDetails();

		$this->doTest(...$details);

		return $details;
    }
}