<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SupplementsTest extends BaseSerializeXML
{
	use SupplementsTrait;

    public function testSupplementWeekend()
    {
		$details = $this->getSupplementWeekend();

		$this->doTest(...$details);

		return $details;
    }

    public function testTestSupplement()
    {
		$details = $this->getTestSupplement();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneSupplements()
    {
		$details = $this->getOneSupplements();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoSupplements()
    {
		$details = $this->getTwoSupplements();

		$this->doTest(...$details);

		return $details;
    }
}