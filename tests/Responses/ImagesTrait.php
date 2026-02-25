<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

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