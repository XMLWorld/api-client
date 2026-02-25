<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;

trait RoomRequestsTrait
{
    protected function getTwoAdults()
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

	protected function getTwoAdultsOneChild()
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

	protected function getTwoAdultsTwoInfants()
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

	protected function getTwoAdultsTwoChildrenTwoInfants()
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

	protected function getOneChildTwoInfants()
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

	protected function getTwoAdultsOneChildrenTwoInfants()
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

	protected function getRoomRequestsTwoAdults()
    {
        list($instance, $serialize, $unserialize) = $this->getTwoAdults();

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

	protected function getRoomRequestsTwoAdultsTwoInfants()
    {
        list($instance, $serialize, $unserialize) = $this->getTwoAdultsTwoInfants();

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

    protected function getRoomRequestsTwoAdultsOneChild()
    {
        list($instance, $serialize, $unserialize) = $this->getTwoAdultsOneChild();

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

    protected function getRoomRequestsTwoAdultsTwoChildrenTwoInfants()
    {
        list($instance, $serialize, $unserialize) = $this->getTwoAdultsTwoChildrenTwoInfants();

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

    public function getThreeRoomRequests()
    {
        $instances = $serializes = $unserializes = [];
        list($instances[0], $serializes[0], $unserializes[0]) = $this->getTwoAdultsTwoInfants();
        list($instances[1], $serializes[1], $unserializes[1]) = $this->getTwoAdultsOneChild();
        list($instances[2], $serializes[2], $unserializes[2]) = $this->getTwoAdultsTwoChildrenTwoInfants();

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