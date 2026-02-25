<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\PropertyResult;
use XMLWorld\ApiClient\Responses\PropertyResults;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertyResultTests extends BaseSerializeXML
{
	use PropertyResultTrait;

    public function testPropertyResult()
    {
		$details = $this->getPropertyResult();

		$this->doTest(...$details);

		return $details;
    }

    public function testOnePropertyResult()
    {
		$details = $this->getOnePropertyResult();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoPropertyResults()
    {
		$details = $this->getTwoPropertyResults();

		$this->doTest(...$details);

		return $details;
    }
}