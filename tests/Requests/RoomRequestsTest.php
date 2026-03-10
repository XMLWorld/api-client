<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomRequestsTest extends BaseSerializeXML
{
    use RoomRequestsTrait;

	#[Test]
	public function roomRequest1() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest1();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function roomRequest2() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest2();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function roomRequest3() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest3();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function roomRequest4() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest4();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function roomRequest5() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest5();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	public function roomRequest6() : array
	{
		list($instance, , ) = $details = $this->getRoomRequest6();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('roomRequest1')]
	public function roomRequestsTwoAdults(array $roomRquest) : array
	{
		list($roomRquestInstance, , ) = $roomRquest;
		list($instance, , ) = $details = $this->getOneRoomRequests($roomRquest);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('roomRequest2')]
	public function roomRequestsTwoAdultsTwoInfants(array $roomRquest) : array
	{
		list($roomRquestInstance, , ) = $roomRquest;
		list($instance, , ) = $details = $this->getOneRoomRequests($roomRquest);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('roomRequest3')]
	public function roomRequestsTwoAdultsOneChild(array $roomRquest) : array
	{
		list($roomRquestInstance, , ) = $roomRquest;
		list($instance, , ) = $details = $this->getOneRoomRequests($roomRquest);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('roomRequest4')]
	public function roomRequestsTwoAdultsTwoChildrenTwoInfants(array $roomRquest) : array
	{
		list($roomRquestInstance, , ) = $roomRquest;
		list($instance, , ) = $details = $this->getOneRoomRequests($roomRquest);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('roomRequest2')]
	#[Depends('roomRequest3')]
	#[Depends('roomRequest4')]
	public function threeRoomRequests(array $roomRquest1, array $roomRquest2, array $roomRquest3) : array
	{
		list($roomRquest1Instance, , ) = $roomRquest1;
		list($roomRquest2Instance, , ) = $roomRquest2;
		list($roomRquest3Instance, , ) = $roomRquest3;
		list($instance, , ) = $details = $this->getThreeRoomRequests($roomRquest1, $roomRquest2, $roomRquest3);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
	}
}