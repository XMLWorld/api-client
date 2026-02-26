<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;

trait ImagesTrait
{
    protected function getImage1() : array
    {
        $instance = new Image(
            'CMSImage_1000.jpg',
            'CMSImageThumb_1000.jpg'
        );

        $serialize = <<<'XML'
<Image>
	<FullSize>CMSImage_1000.jpg</FullSize>
	<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
</Image>
XML;

        $unserialize = <<<'XML'
<Image>
	<FullSize>CMSImage_1000.jpg</FullSize>
	<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
</Image>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getImage2() : array
	{
		$instance = new Image(
			'CMSImage_1001.jpg',
			'CMSImageThumb_1001.jpg'
		);

		$serialize = <<<'XML'
<Image>
	<FullSize>CMSImage_1001.jpg</FullSize>
	<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
</Image>
XML;

		$unserialize = <<<'XML'
<Image>
<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
	<FullSize>CMSImage_1001.jpg</FullSize>
</Image>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

    protected function getOneImages(array $image) : array
    {
		list($instance, $serialize, $unserialize) = $image;

		$instance = new Images($instance);

        $serialize = <<<XML
<Images>
	$serialize
</Images>
XML;

        $unserialize = <<<XML
<Images>
	$unserialize
</Images>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoImages(array $image1, array $image2) : array
    {
		list($image1Instance, $image1Serialize, $image1Unserialize) = $image1;
		list($image2Instance, $image2Serialize, $image2Unserialize) = $image2;

		$instance = new Images(
			$image1Instance,
			$image2Instance
        );

        $serialize = <<<XML
<Images>
	$image1Serialize
	$image2Serialize
</Images>
XML;

        $unserialize = <<<XML
<Images>
	$image1Unserialize
	$image2Unserialize
</Images>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}