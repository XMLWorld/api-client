<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ImagesTest extends BaseSerializeXML
{
	use ImagesTrait;

    public function testImage()
    {
		$details = $this->getImage();

		$this->doTest(...$details);

		return $details;
    }

    public function testOneImage()
    {
		$details = $this->getOneImage();

		$this->doTest(...$details);

		return $details;
    }

    public function testTwoImages()
    {
		$details = $this->getTwoImages();

		$this->doTest(...$details);

		return $details;
    }
}