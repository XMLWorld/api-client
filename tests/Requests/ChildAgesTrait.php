<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;

trait ChildAgesTrait
{
    protected function getChildAge()
    {
        $instance = new ChildAge(15);

        $expected = <<<'XML'
<ChildAge>
	<Age>15</Age>
</ChildAge>
XML;

        return [
            $instance,
            $expected,
            $expected
        ];
    }

	protected function getOneChildAges()
    {
        list($childAgeInstance, $childAgeSerialize, $childAgeUnserialize) = $this->getChildAge();

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

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getTwoChildAges()
    {
        $instance = ChildAges::fromAges(
            8, 15
        );

		$serialize = <<<XML
<ChildAges>
	<ChildAge>
		<Age>8</Age>
	</ChildAge>
	<ChildAge>
		<Age>15</Age>
	</ChildAge>
</ChildAges>
XML;

		$unserialize = <<<XML
<ChildAges>
	<ChildAge>
		<Age>8</Age>
	</ChildAge>
	<ChildAge><Age>15</Age>
	</ChildAge>
</ChildAges>
XML;

        return [
            $instance,
			$serialize,
			$unserialize
        ];
    }
}