<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;

trait ChildAgesTrait
{
    public function testChildAge()
    {
        $instance = new ChildAge(15);

        $expected = <<<'XML'
<ChildAge>
	<Age>15</Age>
</ChildAge>
XML;

        $childAge = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$childAge);

        return $childAge;
    }

	#[Depends('testChildAge')]
    public function testOneChildAges($childAge)
    {
        list($childAgeInstance, $childAgeSerialize, $childAgeUnserialize) = $childAge;

        $instance = new ChildAges($childAgeInstance);

		$serialize = <<<XML
<ChildAges>
	$childAgeSerialize
</ChildAges>
XML;

		$unserialize = <<<XML
<ChildAges>
	$childAgeUnserialize
</ChildAges>
XML;

		$details = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$details);

		return $details;
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