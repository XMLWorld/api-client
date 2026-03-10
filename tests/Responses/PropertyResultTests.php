<?php

namespace XMLWorld\ApiClient\Test\Responses;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertyResultTests extends BaseSerializeXML
{
	use PropertyResultTrait;

	#[Test]
	public function propertyResult0() : array
	{
		list($propertyResult, , ) = $details = $this->getPropertyResult0();

		$this->assertSame(99, $propertyResult->propertyID);
		$this->assertCount(1, $propertyResult->roomTypes);
		$this->assertSame('Example Island', $propertyResult->propertyName);
		$this->assertNull($propertyResult->gIATAID);
		$this->assertSame('USD', $propertyResult->currency);
		$this->assertSame(4.5, $propertyResult->rating);

		$this->assertNull($propertyResult->geographyLevel1ID);
		$this->assertNull($propertyResult->geographyLevel2ID);
		$this->assertNull($propertyResult->geographyLevel3ID);

		$this->assertSame('West Indies', $propertyResult->country);
		$this->assertSame('St Vincent & Grenadines', $propertyResult->area);
		$this->assertSame('Example Island', $propertyResult->region);

		$this->assertNull($propertyResult->longitude);
		$this->assertNull($propertyResult->latitude);
		$this->assertNull($propertyResult->email);
		$this->assertNull($propertyResult->postcode);
		$this->assertNull($propertyResult->address1);
		$this->assertNull($propertyResult->address2);

		$this->assertSame('Intimate, exotic and all-inclusive', $propertyResult->strapline);
		$this->assertSame('Example Island, a high-end luxury resort', $propertyResult->description);
		$this->assertSame('https://xmlhost/custom/content/', $propertyResult->cMSBaseURL);
		$this->assertSame('CMSImage_999.jpg', $propertyResult->mainImage);
		$this->assertSame('CMSImageThumb_999.jpg', $propertyResult->mainImageThumbnail);

		$this->assertNull($propertyResult->images);
		$this->assertNull($propertyResult->errata);

		$this->assertSame(6, $propertyResult->supplier->supplierID);
		$this->assertSame('RMI', $propertyResult->supplier->supplierName);

		$this->doTest(...$details);

		return $details;
	}

	#[Test]
    public function propertyResult1() : array
    {
		list($propertyResult, , ) = $details = $this->getPropertyResult1();

		$this->assertSame(100, $propertyResult->propertyID);
		$this->assertCount(1, $propertyResult->roomTypes);
		$this->assertSame('Example Island', $propertyResult->propertyName);
		$this->assertSame(99999, $propertyResult->gIATAID);
		$this->assertSame('USD', $propertyResult->currency);
		$this->assertSame(4.5, $propertyResult->rating);

		$this->assertSame(6, $propertyResult->geographyLevel1ID);
		$this->assertSame(10, $propertyResult->geographyLevel2ID);
		$this->assertSame(22, $propertyResult->geographyLevel3ID);

		$this->assertSame('West Indies', $propertyResult->country);
		$this->assertSame('St Vincent & Grenadines', $propertyResult->area);
		$this->assertSame('Example Island', $propertyResult->region);

		$this->assertNull($propertyResult->longitude);
		$this->assertNull($propertyResult->latitude);
		$this->assertNull($propertyResult->email);
		$this->assertNull($propertyResult->postcode);
		$this->assertNull($propertyResult->address1);
		$this->assertNull($propertyResult->address2);

		$this->assertSame('Intimate, exotic and all-inclusive', $propertyResult->strapline);
		$this->assertSame('Example Island, a high-end luxury resort', $propertyResult->description);
		$this->assertSame('https://xmlhost/custom/content/', $propertyResult->cMSBaseURL);
		$this->assertSame('CMSImage_999.jpg', $propertyResult->mainImage);
		$this->assertSame('CMSImageThumb_999.jpg', $propertyResult->mainImageThumbnail);

		$this->assertCount(1, $propertyResult->images);
		$this->assertCount(1, $propertyResult->errata);

		$this->assertSame(6, $propertyResult->supplier->supplierID);
		$this->assertSame('RMI', $propertyResult->supplier->supplierName);


		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	public function propertyResult2() : array
	{
		list($propertyResult, , ) = $details = $this->getPropertyResult2();

		$this->assertSame(101, $propertyResult->propertyID);
		$this->assertCount(2, $propertyResult->roomTypes);
		$this->assertSame('Example Island', $propertyResult->propertyName);
		$this->assertSame(99997, $propertyResult->gIATAID);
		$this->assertSame('USD', $propertyResult->currency);
		$this->assertSame(4.5, $propertyResult->rating);

		$this->assertSame(6, $propertyResult->geographyLevel1ID);
		$this->assertSame(10, $propertyResult->geographyLevel2ID);
		$this->assertSame(22, $propertyResult->geographyLevel3ID);

		$this->assertSame('West Indies', $propertyResult->country);
		$this->assertSame('St Vincent & Grenadines', $propertyResult->area);
		$this->assertSame('Example Island', $propertyResult->region);

		$this->assertNull($propertyResult->longitude);
		$this->assertNull($propertyResult->latitude);
		$this->assertNull($propertyResult->email);
		$this->assertNull($propertyResult->postcode);
		$this->assertNull($propertyResult->address1);
		$this->assertNull($propertyResult->address2);

		$this->assertSame('Intimate, exotic and all-inclusive', $propertyResult->strapline);
		$this->assertSame('Example Island, a high-end luxury resort', $propertyResult->description);
		$this->assertSame('https://xmlhost/custom/content/', $propertyResult->cMSBaseURL);
		$this->assertSame('CMSImage_999.jpg', $propertyResult->mainImage);
		$this->assertSame('CMSImageThumb_999.jpg', $propertyResult->mainImageThumbnail);

		$this->assertCount(2, $propertyResult->images);
		$this->assertCount(2, $propertyResult->errata);

		$this->assertSame(6, $propertyResult->supplier->supplierID);
		$this->assertSame('RMI', $propertyResult->supplier->supplierName);


		$this->doTest(...$details);

		return $details;
	}

	#[Test]
	#[Depends('propertyResult1')]
    public function onePropertyResult(array $propertyResult) : array
    {
		list($propertyResultInstance, , ) = $propertyResult;

		list($propertyResults, , ) = $details = $this->getOnePropertyResult($propertyResult);

		$this->assertCount(1, $propertyResults);
		$this->assertSame(1, $propertyResults->totalProperties);
		$this->assertSame($propertyResultInstance, $propertyResults[0]);
		$this->assertSame([$propertyResultInstance], $propertyResults->getPropertyResults());
		$this->assertSame([
			'TotalProperties' => 1,
			$propertyResultInstance
		], iterator_to_array($propertyResults), 'we test the behaviour for a foreach');

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('propertyResult1')]
	#[Depends('propertyResult2')]
    public function twoPropertyResults(array $propertyResult1, array $propertyResult2) : array
    {
		list($propertyResult1Instance, , ) = $propertyResult1;
		list($propertyResult2Instance, , ) = $propertyResult2;

		list($propertyResults, , ) = $details = $this->getTwoPropertyResults($propertyResult1, $propertyResult2);

		$this->assertCount(2, $propertyResults);
		$this->assertSame(2, $propertyResults->totalProperties);
		$this->assertSame($propertyResult1Instance, $propertyResults[0]);
		$this->assertSame($propertyResult2Instance, $propertyResults[1]);
		$this->assertSame([$propertyResult1Instance, $propertyResult2Instance], $propertyResults->getPropertyResults());
		$this->assertSame([
			'TotalProperties' => 2,
			$propertyResult1Instance,
			$propertyResult2Instance
		], iterator_to_array($propertyResults), 'we test the behaviour for a foreach');

		$this->doTest(...$details);

		return $details;
    }
}