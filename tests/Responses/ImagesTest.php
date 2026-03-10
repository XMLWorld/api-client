<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ImagesTest extends BaseSerializeXML
{
	use ImagesTrait;

	#[Test]
    public function image1() : array
    {
		list($instance, , ) = $details = $this->getImage1();

		$this->assertSame('CMSImage_1000.jpg', $instance->fullSize);
		$this->assertSame('CMSImageThumb_1000.jpg', $instance->thumbnail);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function image2() : array
	{
		list($instance, , ) = $details = $this->getImage2();

		$this->assertSame('CMSImage_1001.jpg', $instance->fullSize);
		$this->assertSame('CMSImageThumb_1001.jpg', $instance->thumbnail);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('image1')]
    public function oneImages(array $image) : array
    {
		list($imageInstance, , ) = $image;

		list($instance, , ) = $details = $this->getOneImages($image);

		$this->assertCount(1, $instance, 'it only has one element');

		$this->assertSame($imageInstance, $instance[0]);

		$this->assertSame(
			[$imageInstance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('image1')]
	#[Depends('image2')]
    public function testTwoImages(array $image1, array $image2) : array
    {
		list($image1Instance, , ) = $image1;
		list($image2Instance, , ) = $image2;

		list($instance, , ) = $details = $this->getTwoImages($image1, $image2);

		$this->assertCount(2, $instance, 'it has two elements');

		$this->assertSame($image1Instance, $instance[0]);
		$this->assertSame($image2Instance, $instance[1]);

		$this->assertSame(
			[$image1Instance, $image2Instance],
			iterator_to_array($instance),
			'we test the behaviour for a foreach'
		);

		$this->doTest(...$details);

		return $details;
    }
}