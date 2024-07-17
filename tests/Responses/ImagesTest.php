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

class ImagesTest extends BaseSerializeXML
{
    public function testImage()
    {
        $image = new Image(
            'CMSImage_1000.jpg',
            'CMSImageThumb_1000.jpg'
        );

        $this->serialize(
            '<Image>
				<FullSize>CMSImage_1000.jpg</FullSize>
				<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
			</Image>',
            $image
        );

        $this->unserialize(
            '<Image>
				<FullSize>CMSImage_1000.jpg</FullSize>
				<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
			</Image>',
            $image
        );

        return $image;
    }


    /**
     * @depends testImage
     */
    public function testOneImage($image)
    {
        $oneImage = new Images($image);

        $this->serialize(
            '<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
			</Images>',
            $oneImage
        );

        $this->unserialize(
            '<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
			</Images>',
            $oneImage
        );

        return $oneImage;
    }

    /**
     * @depends testImage
     */
    public function testTwoImages($image)
    {
        $twoImages = new Images(
            $image,
            new Image(
                'CMSImage_1001.jpg',
                'CMSImageThumb_1001.jpg'
            )
        );

        $this->serialize(
            '<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
				<Image>
					<FullSize>CMSImage_1001.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
				</Image>
			</Images>',
            $twoImages
        );

        $this->unserialize(
            '<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
				<Image>
					<FullSize>CMSImage_1001.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
				</Image>
			</Images>',
            $twoImages
        );

        return $twoImages;
    }

}