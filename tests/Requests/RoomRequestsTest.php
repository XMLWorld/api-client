<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class RoomRequestsTest extends BaseSerializeXML
{
    public static function getTwoAdults()
    {
        return RoomRequest::fromAges(2);
    }

    public static function getTwoAdultsOneChild()
    {
        return RoomRequest::fromAges(
            2,
            10
        );
    }

    public static function geTtwoAdultsTwoInfants()
    {
        return RoomRequest::fromAges(
            2,
            1, 2
        );
    }

    public static function getTwoAdultsTwoChildrenTwoInfants()
    {
        return RoomRequest::fromAges(
            2,
            9, 1, 8, 2
        );
    }

    public function testTwoAdults()
    {
        $twoAdults = self::getTwoAdults();

        $this->serialize(
            '<RoomRequest>
				<Adults>2</Adults>
				<Children>0</Children>
			</RoomRequest>',
            $twoAdults
        );

        $this->unserialize(
            '<RoomRequest>
				<Children>0</Children>
				<Adults>2</Adults>
				<ChildAges/>
			</RoomRequest>',
            $twoAdults
        );

        return $twoAdults;
    }

    public function testTwoAdultsOneChild()
    {
        $twoAdultsOneChild = self::getTwoAdultsOneChild();

        $this->serialize(
            '<RoomRequest>
				<Adults>2</Adults>
				<Children>1</Children>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
            $twoAdultsOneChild
        );

        $this->unserialize(
            '<RoomRequest>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
				<Adults>2</Adults>
				<Children>1</Children>
			</RoomRequest>',
            $twoAdultsOneChild
        );

        return $twoAdultsOneChild;
    }

    public function testTwoAdultsTwoInfants()
    {
        $twoAdultsTwoInfants = self::geTtwoAdultsTwoInfants();

        $this->serialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsTwoInfants
        );

        $this->unserialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsTwoInfants
        );

        return $twoAdultsTwoInfants;
    }

    public function testOneChildTwoInfants()
    {
        $oneChildTwoInfants = RoomRequest::fromAges(
            null,
            1, 2, 10
        );

        $this->serialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $oneChildTwoInfants
        );

        $this->unserialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $oneChildTwoInfants
        );

        return $oneChildTwoInfants;
    }

    public function testTwoAdultsOneChildrenTwoInfants()
    {
        $twoAdultsOneChildrenTwoInfants = RoomRequest::fromAges(
            2,
            1, 8, 2
        );

        $this->serialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsOneChildrenTwoInfants
        );

        $this->unserialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsOneChildrenTwoInfants
        );

        return $twoAdultsOneChildrenTwoInfants;
    }

    public function testTwoAdultsTwoChildrenTwoInfants()
    {
        $twoAdultsTwoChildrenTwoInfants = self::getTwoAdultsTwoChildrenTwoInfants();

        $this->serialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsTwoChildrenTwoInfants
        );

        $this->unserialize(
            '<RoomRequest>
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
			</RoomRequest>',
            $twoAdultsTwoChildrenTwoInfants
        );

        return $twoAdultsTwoChildrenTwoInfants;
    }

    /**
     * @depends testTwoAdults
     */
    public function testRoomRequestsTwoAdults($twoAdults)
    {
        $roomRequestsTwoAdults = new RoomRequests($twoAdults);

        $this->serialize(
            '<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>0</Children>
				</RoomRequest>
			</RoomRequests>',
            $roomRequestsTwoAdults
        );

        $this->unserialize(
            '<RoomRequests>
				<RoomRequest>
					<Children>0</Children>
					<Adults>2</Adults>
				</RoomRequest>
			</RoomRequests>',
            $roomRequestsTwoAdults
        );

        return $roomRequestsTwoAdults;
    }

    /**
     * @depends testTwoAdultsTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoInfants($twoAdultsTwoInfants)
    {
        $roomRequestsTwoAdultsTwoInfants = new RoomRequests($twoAdultsTwoInfants);

        $this->serialize(
            '<RoomRequests>
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
			</RoomRequests>',
            $roomRequestsTwoAdultsTwoInfants
        );

        $this->unserialize(
            '<RoomRequests>
				<RoomRequest>
				    <Adults>2</Adults>
					<ChildAges>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
					<Children>2</Children>
				</RoomRequest>
			</RoomRequests>',
            $roomRequestsTwoAdultsTwoInfants
        );

        return $roomRequestsTwoAdultsTwoInfants;
    }

    /**
     * @depends testTwoAdultsOneChild
     */
    public function testRoomRequestsTwoAdultsOneChild($twoAdultsOneChild)
    {
        $roomRequestsTwoAdultsOneChild = new RoomRequests($twoAdultsOneChild);

        $this->serialize(
            '<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
            $roomRequestsTwoAdultsOneChild
        );

        $this->unserialize(
            '<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
            $roomRequestsTwoAdultsOneChild
        );

        return $roomRequestsTwoAdultsOneChild;
    }

    /**
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testRoomRequestsTwoAdultsTwoChildrenTwoInfants($twoAdultsTwoChildrenTwoInfants)
    {
        $roomRequestsTwoAdultsTwoChildrenTwoInfants = new RoomRequests($twoAdultsTwoChildrenTwoInfants);

        $this->serialize(
            '<RoomRequests>
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
			</RoomRequests>',
            $roomRequestsTwoAdultsTwoChildrenTwoInfants
        );

        $this->unserialize(
            '<RoomRequests>
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
			</RoomRequests>',
            $roomRequestsTwoAdultsTwoChildrenTwoInfants
        );

        return $roomRequestsTwoAdultsTwoChildrenTwoInfants;
    }

    /**
     * @depends testTwoAdultsTwoInfants
     * @depends testTwoAdultsOneChild
     * @depends testTwoAdultsTwoChildrenTwoInfants
     */
    public function testThreeRoomRequests($twoAdultsTwoInfants, $twoAdultsOneChild, $twoAdultsTwoChildrenTwoInfants)
    {
        $threeRoomRequests = new RoomRequests(
            $twoAdultsTwoInfants,
            $twoAdultsOneChild,
            $twoAdultsTwoChildrenTwoInfants
        );

        $this->serialize(
            '<RoomRequests>
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
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
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
			</RoomRequests>',
            $threeRoomRequests
        );

        $this->unserialize(
            '<RoomRequests>
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
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
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
			</RoomRequests>',
            $threeRoomRequests
        );

        return $threeRoomRequests;
    }

}