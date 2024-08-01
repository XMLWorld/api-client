<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;

trait RoomRequestsTrait
{
    public function testTwoAdults()
    {
        $instance = RoomRequest::fromAges(2);

        $serialize = '<RoomRequest>
				<Adults>2</Adults>
				<Children>0</Children>
			</RoomRequest>';

        $unserialize = '<RoomRequest>
				<Children>0</Children>
				<Adults>2</Adults>
				<ChildAges/>
			</RoomRequest>';

        $twoAdults = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$twoAdults);

        return $twoAdults;
    }

    public function testTwoAdultsOneChild()
    {
        $instance = RoomRequest::fromAges(
            2,
            10
        );

        $serialize = '<RoomRequest>
				<Adults>2</Adults>
				<Children>1</Children>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>';

        $unserialize = '<RoomRequest>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
				<Adults>2</Adults>
				<Children>1</Children>
			</RoomRequest>';

        $twoAdultsOneChild = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$twoAdultsOneChild);

        return $twoAdultsOneChild;
    }

    public function testTwoAdultsTwoInfants()
    {
        $instance = RoomRequest::fromAges(
            2,
            1, 2
        );

        $serialize = '<RoomRequest>
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
			</RoomRequest>';

        $unserialize = '<RoomRequest>
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
			</RoomRequest>';

        $twoAdultsTwoInfants = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$twoAdultsTwoInfants);

        return $twoAdultsTwoInfants;
    }

    public function testTwoAdultsTwoChildrenTwoInfants()
    {
        $instance = RoomRequest::fromAges(
            2,
            9, 1, 8, 2
        );

        $serialize = '<RoomRequest>
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
			</RoomRequest>';

        $unserialize = '<RoomRequest>
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
			</RoomRequest>';

        $twoAdultsTwoChildrenTwoInfants = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$twoAdultsTwoChildrenTwoInfants);

        return $twoAdultsTwoChildrenTwoInfants;
    }

    public function testOneChildTwoInfants()
    {
        $instance = RoomRequest::fromAges(
            null,
            1, 2, 10
        );

        $serialize = '<RoomRequest>
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
			</RoomRequest>';

        $unserialize = '<RoomRequest>
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
			</RoomRequest>';

        $oneChildTwoInfants = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$oneChildTwoInfants);

        return $oneChildTwoInfants;
    }

    public function testTwoAdultsOneChildrenTwoInfants()
    {
        $instance = RoomRequest::fromAges(
            2,
            1, 8, 2
        );

        $serialize = '<RoomRequest>
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
			</RoomRequest>';

        $unserialize = '<RoomRequest>
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
			</RoomRequest>';

        $twoAdultsOneChildrenTwoInfants = [
            $instance,
            $serialize,
            $unserialize,
        ];

        $this->doTest(...$twoAdultsOneChildrenTwoInfants);

        return $twoAdultsOneChildrenTwoInfants;
    }

    /**
     * @depends testTwoAdults
     */
    public function testRoomRequestsTwoAdults($twoAdults)
    {
        list($instance, $serialize, $unserialize) = $twoAdults;

        $instance = new RoomRequests($instance);

        $roomRequestsTwoAdults = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$roomRequestsTwoAdults);

        return $roomRequestsTwoAdults;
    }

    /**
     * @depends testTwoAdultsTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoInfants($twoAdultsTwoInfants)
    {
        list($instance, $serialize, $unserialize) = $twoAdultsTwoInfants;

        $instance = new RoomRequests($instance);

        $roomRequestsTwoAdultsTwoInfants = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$roomRequestsTwoAdultsTwoInfants);

        return $roomRequestsTwoAdultsTwoInfants;
    }

    /**
     * @depends testTwoAdultsOneChild
     */
    public function testRoomRequestsTwoAdultsOneChild($twoAdultsOneChild)
    {
        list($instance, $serialize, $unserialize) = $twoAdultsOneChild;

        $instance = new RoomRequests($instance);

        $roomRequestsTwoAdultsOneChild = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$roomRequestsTwoAdultsOneChild);

        return $roomRequestsTwoAdultsOneChild;
    }

    /**
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoChildrenTwoInfants($twoAdultsTwoChildrenTwoInfants)
    {
        list($instance, $serialize, $unserialize) = $twoAdultsTwoChildrenTwoInfants;

        $instance = new RoomRequests($instance);

        $roomRequestsTwoAdultsTwoChildrenTwoInfants = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$roomRequestsTwoAdultsTwoChildrenTwoInfants);

        return $roomRequestsTwoAdultsTwoChildrenTwoInfants;
    }

    /**
     * @depends testTwoAdultsTwoInfants
     * @depends testTwoAdultsOneChild
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testThreeRoomRequests($twoAdultsTwoInfants, $twoAdultsOneChild, $twoAdultsTwoChildrenTwoInfants)
    {
        $instances = $serializes = $unserializes = [];
        list($instances[0], $serializes[0], $unserializes[0]) = $twoAdultsTwoInfants;
        list($instances[1], $serializes[1], $unserializes[1]) = $twoAdultsOneChild;
        list($instances[2], $serializes[2], $unserializes[2]) = $twoAdultsTwoChildrenTwoInfants;

        $instance = new RoomRequests(...$instances);

        $threeRoomRequests = $this->wrap(
            $instance,
            implode(PHP_EOL, $serializes),
            implode(PHP_EOL, $unserializes),
        );

        $this->doTest(...$threeRoomRequests);

        return $threeRoomRequests;
    }
}