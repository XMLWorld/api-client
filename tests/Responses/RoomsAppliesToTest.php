<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomsAppliesToTest extends BaseSerializeXML
{
    public function testRoomsAppliesToOneRoom()
    {
        $roomsAppliesTo = new RoomsAppliesTo(1);

        $this->serialize(
            '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
			</RoomsAppliesTo>',
            $roomsAppliesTo
        );

        $this->unserialize(
            '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
			</RoomsAppliesTo>',
            $roomsAppliesTo
        );

        return $roomsAppliesTo;
    }

    public function testRoomsAppliesToTowRooms()
    {
        $roomsAppliesTo = new RoomsAppliesTo(1, 2, 3, 4);

        $this->serialize(
            '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
				<RoomRequest>2</RoomRequest>
				<RoomRequest>3</RoomRequest>
				<RoomRequest>4</RoomRequest>
			</RoomsAppliesTo>',
            $roomsAppliesTo
        );

        $this->unserialize(
            '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
				<RoomRequest>2</RoomRequest>
				<RoomRequest>3</RoomRequest>
				<RoomRequest>4</RoomRequest>
			</RoomsAppliesTo>',
            $roomsAppliesTo
        );

        return $roomsAppliesTo;
    }
}