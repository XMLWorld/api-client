<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;

trait ChildAgesTrait
{
    public function testChildAge()
    {
        $instance = new ChildAge(15);

        $expected = '<ChildAge>
				<Age>15</Age>
			</ChildAge>';

        $childAge = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$childAge);

        return $childAge;
    }

    /**
     * @depends testChildAge
     */
    public function testOneChildAges($childAge)
    {
        list($instance, $serialize, ) = $childAge;

        $instance = new ChildAges($instance);

        $oneChildAges = $this->wrap($instance, $serialize);

        $this->doTest(...$oneChildAges);

        return $oneChildAges;
    }

    public function testTwoChildAges()
    {
        $instance = ChildAges::fromAges(
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

        $twoChildAges = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$twoChildAges);

        return $twoChildAges;
    }
}