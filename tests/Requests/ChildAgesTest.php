<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ChildAgesTest extends BaseSerializeXML
{
    public function testChildAge()
    {
        $childAge = new ChildAge(15);

        $expected = '<ChildAge>
				<Age>15</Age>
			</ChildAge>';

        $this->serialize(
            $expected,
            $childAge
        );

        $this->unserialize(
            $expected,
            $childAge
        );

        return $childAge;
    }

    /**
     * @depends testChildAge
     * @param $childAge
     * @return ChildAges
     */
    public function testOneChildAges($childAge)
    {
        $expected = '<ChildAges>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>';

        $oneChildAges = new ChildAges($childAge);

        $this->serialize(
            $expected,
            $oneChildAges
        );

        $this->unserialize(
            $expected,
            $oneChildAges
        );

        return $oneChildAges;
    }

    /**
     * @return ChildAges
     */
    public function testTwoChildAges()
    {
        $twoChildAges = ChildAges::fromAges(
            8, 15
        );

        $expected = '<ChildAges>
				<ChildAge>
					<Age>8</Age>
				</ChildAge>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>';

        $this->serialize(
            $expected,
            $twoChildAges
        );

        $this->unserialize(
            $expected,
            $twoChildAges
        );

        return $twoChildAges;
    }
}