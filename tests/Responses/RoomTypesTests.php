<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomTypesTests extends BaseSerializeXML
{
	use RoomTypesTrait;

    public function testRoomTypeOne()
    {
		$details = $this->getRoomTypeOne();

		$this->doTest(...$details);

		return $details;
    }

    public function testRoomTypeTwo()
    {
		$details = $this->getRoomTypeTwo();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneRoomType()
    {
		$details = $this->getOneRoomType();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoRoomTypes()
    {
		$details = $this->getTwoRoomTypes();

		$this->doTest(...$details);

		return $details;
    }
}