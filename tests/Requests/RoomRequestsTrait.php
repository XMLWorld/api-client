<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;

trait RoomRequestsTrait
{
    protected function getRoomRequest1() : array
    {
        $instance = RoomRequest::fromAges(2);

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>0</Children>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<Children>0</Children>
	<Adults>2</Adults>
	<ChildAges/>
</RoomRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getRoomRequest2() : array
    {
        $instance = RoomRequest::fromAges(
            2,
            10
        );

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>1</Children>
	<ChildAges>
		<ChildAge>
			<Age>10</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<ChildAges>
		<ChildAge>
			<Age>10</Age>
		</ChildAge>
	</ChildAges>
	<Adults>2</Adults>
	<Children>1</Children>
</RoomRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getRoomRequest3() : array
    {
        $instance = RoomRequest::fromAges(
            2,
            1, 2
        );

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>2</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>2</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

       	return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getRoomRequest4() : array
    {
        $instance = RoomRequest::fromAges(
            2,
            9, 1, 8, 2
        );

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>4</Children>
	<ChildAges>
		<ChildAge>
			<Age>9</Age>
		</ChildAge>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>8</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<Children>4</Children>
	<ChildAges>
		<ChildAge>
			<Age>9</Age>
		</ChildAge>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>8</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
	<Adults>2</Adults>
</RoomRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getRoomRequest5() : array
    {
        $instance = RoomRequest::fromAges(
            null,
            1, 2, 10
        );

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>0</Adults>
	<Children>3</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
		<ChildAge>
			<Age>10</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<Children>3</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
		<ChildAge>
			<Age>10</Age>
		</ChildAge>
	</ChildAges>
	<Adults>0</Adults>
</RoomRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getRoomRequest6() : array
    {
        $instance = RoomRequest::fromAges(
            2,
            1, 8, 2
        );

        $serialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>3</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>8</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        $unserialize = <<<'XML'
<RoomRequest>
	<Adults>2</Adults>
	<Children>3</Children>
	<ChildAges>
		<ChildAge>
			<Age>1</Age>
		</ChildAge>
		<ChildAge>
			<Age>8</Age>
		</ChildAge>
		<ChildAge>
			<Age>2</Age>
		</ChildAge>
	</ChildAges>
</RoomRequest>
XML;

        return [
            $instance,
            $serialize,
            $unserialize,
        ];
    }

	protected function getOneRoomRequests(array $roomRequest) : array
    {
        list($instance, $serialize, $unserialize) = $roomRequest;

        $instance = new RoomRequests($instance);

        $serialize = <<<XML
<RoomRequests>
	$serialize
</RoomRequests>
XML;
		$unserialize = <<<XML
<RoomRequests>
	$unserialize
</RoomRequests>
XML;
		return [
			$instance,
			$serialize,
			$unserialize,
		];
    }

    public function getThreeRoomRequests(array $roomRquest1, array $roomRquest2, array $roomRquest3) : array
    {
        $instances = $serializes = $unserializes = [];
        list($instances[0], $serializes[0], $unserializes[0]) = $roomRquest1;
        list($instances[1], $serializes[1], $unserializes[1]) = $roomRquest2;
        list($instances[2], $serializes[2], $unserializes[2]) = $roomRquest3;

        $instance = new RoomRequests(...$instances);

		$serialize = <<<XML
<RoomRequests>
	$serializes[0]
	$serializes[1]
	$serializes[2]
</RoomRequests>
XML;
		$unserialize = <<<XML
<RoomRequests>
	$unserializes[0]
	$unserializes[1]
	$unserializes[2]
</RoomRequests>
XML;
		return [
			$instance,
			$serialize,
			$unserialize,
		];
    }
}