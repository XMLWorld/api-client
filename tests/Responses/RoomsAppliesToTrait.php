<?php

namespace XMLWorld\ApiClient\Test\Responses;


use XMLWorld\ApiClient\Responses\RoomsAppliesTo;

trait RoomsAppliesToTrait
{
    protected function getRoomsAppliesTo()
    {
        $instance = new RoomsAppliesTo(1);

        $serialize = <<<'XML'
<RoomsAppliesTo>
	<RoomRequest>1</RoomRequest>
</RoomsAppliesTo>
XML;

		$unserialize = <<<'XML'
<RoomsAppliesTo>
	<RoomRequest>1</RoomRequest></RoomsAppliesTo>
XML;

        return [
            $instance,
			$serialize,
			$unserialize
        ];
    }

	protected function getRoomsAppliesToFourRooms()
    {
        $instance = new RoomsAppliesTo(1, 2, 3, 4);

		$serialize = <<<'XML'
<RoomsAppliesTo>
	<RoomRequest>1</RoomRequest>
	<RoomRequest>2</RoomRequest>
	<RoomRequest>3</RoomRequest>
	<RoomRequest>4</RoomRequest>
</RoomsAppliesTo>
XML;
		$unserialize = <<<'XML'
<RoomsAppliesTo>
	<RoomRequest>1</RoomRequest>
	<RoomRequest>2</RoomRequest><RoomRequest>3</RoomRequest>
	<RoomRequest>4</RoomRequest>
</RoomsAppliesTo>
XML;

        return [
            $instance,
			$serialize,
			$unserialize
        ];
    }
}