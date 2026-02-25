<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ErrataTest extends BaseSerializeXML
{
	use ErrataTrait;

    public function testErratum()
    {
		$details = $this->getErratum();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneErrata()
    {
		$details = $this->getOneErrata();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoErrata()
    {
		$details = $this->getTwoErrata();

		$this->doTest(...$details);

		return $details;
    }
}