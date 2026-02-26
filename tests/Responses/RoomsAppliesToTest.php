<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomsAppliesToTest extends BaseSerializeXML
{
	use RoomsAppliesToTrait;

	#[Test]
    public function roomsAppliesToOneRoom() : array
    {
		list($instance, , ) = $details = $this->getRoomsAppliesTo();

		$this->assertCount(1, $instance->roomRequest, 'it only contains one element');
		$this->assertIsArray($instance->roomRequest, 'the container roomRequest is an array');
		$this->assertSame([1], $instance->roomRequest, 'the content is correct');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function roomsAppliesToTowRooms() : array
    {
		list($instance, , ) = $details = $this->getRoomsAppliesToFourRooms();

		$this->assertCount(4, $instance->roomRequest, 'it contains two elements');
		$this->assertIsArray($instance->roomRequest, 'the container roomRequest is an array');
		$this->assertSame([1, 2, 3, 4], $instance->roomRequest, 'the content is correct');

		$this->doTest(...$details);

		return $details;
    }
}