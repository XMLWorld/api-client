<?php

namespace XMLWorld\ApiClient\Test\Responses;


use XMLWorld\ApiClient\Responses\RoomsAppliesTo;

trait RoomsAppliesToTrait
{
    public function testRoomsAppliesTo()
    {
        $instance = new RoomsAppliesTo(1);

        $expected = '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
			</RoomsAppliesTo>';

        $roomsAppliesTo = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$roomsAppliesTo);

        return $roomsAppliesTo;
    }

    public function testRoomsAppliesToFourRooms()
    {
        $instance = new RoomsAppliesTo(1, 2, 3, 4);

        $expected = '<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
				<RoomRequest>2</RoomRequest>
				<RoomRequest>3</RoomRequest>
				<RoomRequest>4</RoomRequest>
			</RoomsAppliesTo>';

        $roomsAppliesToFourRooms = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$roomsAppliesToFourRooms);

        return $roomsAppliesToFourRooms;
    }
}