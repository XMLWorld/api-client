<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;

trait ImagesTrait
{
    protected function getImage()
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

    protected function getOneImage()
    {
		list($instance, $serialize, $unserialize) = $this->getImage();

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

    protected function getTwoImages()
    {
		list($instance, $serialize, $unserialize) = $this->getImage();

		$instance = new Images(
			$instance,
            new Image(
                'CMSImage_1001.jpg',
                'CMSImageThumb_1001.jpg'
            )
        );

        $serialize = <<<XML
<Images>
	$serialize
	<Image>
		<FullSize>CMSImage_1001.jpg</FullSize>
		<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
	</Image>
</Images>
XML;

        $unserialize = <<<XML
<Images>
	$unserialize
	<Image>
		<FullSize>CMSImage_1001.jpg</FullSize>
		<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
	</Image>
</Images>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}