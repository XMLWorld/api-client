<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomRequestsTest extends BaseSerializeXML
{
    use RoomRequestsTrait;

	public function testTwoAdults()
	{
		$details = $this->getTwoAdults();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoAdultsOneChild()
	{
		$details = $this->getTwoAdultsOneChild();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoAdultsTwoInfants()
	{
		$details = $this->getTwoAdultsTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoAdultsTwoChildrenTwoInfants()
	{
		$details = $this->getTwoAdultsTwoChildrenTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testOneChildTwoInfants()
	{
		$details = $this->getOneChildTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testTwoAdultsOneChildrenTwoInfants()
	{
		$details = $this->getTwoAdultsOneChildrenTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testRoomRequestsTwoAdults()
	{
		$details = $this->getRoomRequestsTwoAdults();

		$this->doTest(...$details);

		return $details;
	}

	public function testRoomRequestsTwoAdultsTwoInfants()
	{
		$details = $this->getRoomRequestsTwoAdultsTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testRoomRequestsTwoAdultsOneChild()
	{
		$details = $this->getRoomRequestsTwoAdultsOneChild();

		$this->doTest(...$details);

		return $details;
	}

	public function testRoomRequestsTwoAdultsTwoChildrenTwoInfants()
	{
		$details = $this->getRoomRequestsTwoAdultsTwoChildrenTwoInfants();

		$this->doTest(...$details);

		return $details;
	}

	public function testThreeRoomRequests()
	{
		$details = $this->getThreeRoomRequests();

		$this->doTest(...$details);

		return $details;
	}
}