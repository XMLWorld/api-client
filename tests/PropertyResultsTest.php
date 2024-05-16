<?php

namespace XMLWorld\ApiClient\Test;

use PHPUnit\Framework\TestCase;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\PropertyResult;
use XMLWorld\ApiClient\Responses\PropertyResults;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\RoomType;
use XMLWorld\ApiClient\Responses\RoomTypes;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Supplier;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;

class PropertyResultsTest extends TestCase
{
    /**
     * @test
     */
    public function roomsAppliesTo1Room()
    {
        $roomsAppliesTo1Room = new RoomsAppliesTo(1);

        $this->assertCount(1, $roomsAppliesTo1Room->roomRequest, 'it only contains one element');

        $this->assertIsArray($roomsAppliesTo1Room->roomRequest, 'the container roomRequest is an array');

        $this->assertSame([1], $roomsAppliesTo1Room->roomRequest, 'the content is correct');

        return $roomsAppliesTo1Room;
    }

    /**
     * @test
     */
    public function roomsAppliesTo2Room2()
    {
        $roomsAppliesTo2Room2 = new RoomsAppliesTo(1,2);

        $this->assertCount(2, $roomsAppliesTo2Room2->roomRequest, 'it contains two elements');

        $this->assertIsArray($roomsAppliesTo2Room2->roomRequest, 'the container roomRequest is an array');

        $this->assertSame([1, 2], $roomsAppliesTo2Room2->roomRequest, 'the content is correct');

        return $roomsAppliesTo2Room2;
    }

    /**
     * @test
     */
    public function specialOffert()
    {
        $specialOffert = new SpecialOffer(
            'Early Bird Booking',
            'Adult Only',
            10,
            'All',
            440
        );

        $this->assertSame('Early Bird Booking', $specialOffert->name, 'name is correct');
        $this->assertSame('Adult Only', $specialOffert->type, 'type is correct');
        $this->assertSame(10.0, $specialOffert->value, 'value is correct');
        $this->assertSame('All', $specialOffert->paxType, 'paxType is correct');
        $this->assertSame(440.0, $specialOffert->total, 'total is correct');

        return $specialOffert;
    }

    /**
     * @test
     * @depends specialOffert
     */
    public function oneSpecialOffertsOnly($specialOffert)
    {
        $oneSpecialOffertsOnly = new SpecialOffers($specialOffert);

        $this->assertCount(1, $oneSpecialOffertsOnly, 'it only has one element');

        $this->assertSame($specialOffert, $oneSpecialOffertsOnly[0]);

        return $oneSpecialOffertsOnly;
    }

    /**
     * @test
     * @depends specialOffert
     */
    public function twoSpecialOfferts($specialOffert)
    {
        $specialOffer2 = new SpecialOffer(
            'Example special offer 2',
            'Free Kids',
            1,
            null,
            1000,
            'test desc'
        );

        $twoSpecialOfferts = new SpecialOffers(
            $specialOffert,
            $specialOffer2
        );

        $this->assertCount(2, $twoSpecialOfferts, 'it has two elements');

        $this->assertSame($specialOffert, $twoSpecialOfferts[0]);
        $this->assertSame($specialOffer2, $twoSpecialOfferts[1]);

        return $twoSpecialOfferts;
    }

    /**
     * @test
     */
    public function tax()
    {
        $tax = new Tax(
            'Government Tax',
            true,
            423.15
        );

        $this->assertSame('Government Tax', $tax->taxName, 'taxName is correct');
        $this->assertSame(true, $tax->inclusive, 'inclusive is correct');
        $this->assertSame(423.15, $tax->total, 'total is correct');

        return $tax;
    }

    /**
     * @test
     * @depends tax
     */
    public function oneTaxesOnly($tax)
    {
        $oneTaxesOnly = new Taxes($tax);

        $this->assertCount(1, $oneTaxesOnly, 'it only has one element');

        $this->assertSame($tax, $oneTaxesOnly[0]);

        return $oneTaxesOnly;
    }

    /**
     * @test
     * @depends tax
     */
    public function twoTaxes($tax)
    {
        $taxTwo = new Tax(
            'Government Tax',
            true,
            423.15
        );

        $twoTaxes = new Taxes($tax, $taxTwo);

        $this->assertCount(2, $twoTaxes, 'it has two elements');

        $this->assertSame($tax, $twoTaxes[0]);
        $this->assertSame($taxTwo, $twoTaxes[1]);

        return $twoTaxes;
    }

    /**
     * @test
     */
    public function supplement()
    {
        $supplement = new Supplement(
            'test supplement',
            'Per Night',
            'Per Person',
            220,
            'Adult Only'
        );

        $this->assertSame('test supplement', $supplement->name);
        $this->assertSame('Per Night', $supplement->duration);
        $this->assertSame('Per Person', $supplement->multiplier);
        $this->assertSame(220.0, $supplement->total);
        $this->assertSame('Adult Only', $supplement->paxType);

        return $supplement;
    }

    /**
     * @test
     * @depends supplement
     * @return Supplements
     */
    public function oneSupplementOnly($suplement)
    {
        $oneSupplement = new Supplements($suplement);

        $this->assertCount(1, $oneSupplement, 'it only has one element');

        $this->assertSame($suplement, $oneSupplement[0]);

        return $oneSupplement;
    }

    /**
     * @test
     * @depends supplement
     * @return Supplements
     */
    public function twoSupplements($suplement)
    {
        $testSupplement = new Supplement(
            'test supplement',
            'Per Night',
            'Per Person',
            220,
            'Adult Only'
        );

        $twoSupplements = new Supplements(
            $suplement,
            $testSupplement
        );

        $this->assertCount(2, $twoSupplements, 'it has two elements');

        $this->assertSame($suplement, $twoSupplements[0]);
        $this->assertSame($testSupplement, $twoSupplements[1]);

        return $twoSupplements;
    }

    /**
     * @test
     */
    public function cancellationPolicy()
    {
        $cancellationPolicy = new CancellationPolicy(
            '2020-07-18',
            440
        );

        $this->assertSame('2020-07-18', $cancellationPolicy->cancelBy, 'cancelBy is correct');
        $this->assertSame(440.0, $cancellationPolicy->penalty, 'penalty is correct');

        return $cancellationPolicy;
    }

    /**
     * @test
     * @depends cancellationPolicy
     */
    public function oneCancellationPolicyOnly($cancellationPolicy)
    {
        $oneCancellationPolicyOnly = new CancellationPolicies($cancellationPolicy);

        $this->assertCount(1, $oneCancellationPolicyOnly, 'it only has one element');

        $this->assertSame($cancellationPolicy, $oneCancellationPolicyOnly[0]);

        return $oneCancellationPolicyOnly;
    }

    /**
     * @test
     * @depends cancellationPolicy
     */
    public function twoCancellationPolicies($cancellationPolicy)
    {
        $secondPolicy = new CancellationPolicy(
            '2020-07-18',
            1148.55
        );

        $twoCancellationPolicies = new CancellationPolicies(
            $cancellationPolicy,
            $secondPolicy
        );

        $this->assertCount(2, $twoCancellationPolicies, 'it has two elements');

        $this->assertSame($cancellationPolicy, $twoCancellationPolicies[0]);
        $this->assertSame($secondPolicy, $twoCancellationPolicies[1]);

        return $twoCancellationPolicies;
    }

    /**
     * @test
     * @depends roomsAppliesTo1Room
     * @depends oneSpecialOffertsOnly
     * @depends oneTaxesOnly
     * @depends oneSupplementOnly
     * @depends oneCancellationPolicyOnly
     */
    public function roomType1($roomsAppliesTo1Room, $oneSpecialOffertsOnly, $oneTaxesOnly, $oneSupplementOnly, $oneCancellationPolicyOnly)
    {
        $roomType = new RoomType(
            998,
            null,
            null,
            1,
            'Example Villa',
            'Sea View',
            2,
            0,
            0,
            true,
            3960,
            4400,
            $roomsAppliesTo1Room,
            $oneSupplementOnly,
            $oneSpecialOffertsOnly,
            $oneTaxesOnly,
            $oneCancellationPolicyOnly
        );

        $this->assertSame(998, $roomType->roomID);
        $this->assertNull($roomType->ratecode);
        $this->assertNull($roomType->propertyRoomTypeID);
        $this->assertSame(1, $roomType->mealBasisID);
        $this->assertSame('Example Villa', $roomType->name);

        $this->assertIsArray($roomType->roomsAppliesTo->roomRequest);
        $this->assertCount(1, $roomType->roomsAppliesTo->roomRequest);

        $this->assertCount(1, $roomType->supplements);
        $this->assertCount(1, $roomType->specialOffers);
        $this->assertCount(1, $roomType->taxes);
        $this->assertCount(1, $roomType->cancellationPolicies);

        return $roomType;
    }

    /**
     * @test
     * @depends roomsAppliesTo2Room2
     * @depends twoSpecialOfferts
     * @depends twoTaxes
     * @depends twoSupplements
     * @depends twoCancellationPolicies
     */
    public function roomType2($roomsAppliesTo2Room2, $twoSpecialOfferts, $twoTaxes, $twoSupplements, $twoCancellationPolicies)
    {
        $roomType2 = new RoomType(
            999,
            null,
            1,
            1,
            'Example Villa',
            'Sea View',
            2,
            2,
            1,
            true,
            5896.80,
            6565.35,
            $roomsAppliesTo2Room2,
            $twoSupplements,
            $twoSpecialOfferts,
            $twoTaxes,
            $twoCancellationPolicies
        );

        $this->assertSame(999, $roomType2->roomID);
        $this->assertNull($roomType2->ratecode);
        $this->assertSame(1, $roomType2->propertyRoomTypeID);
        $this->assertSame(1, $roomType2->mealBasisID);
        $this->assertSame('Example Villa', $roomType2->name);

        $this->assertIsArray($roomType2->roomsAppliesTo->roomRequest);
        $this->assertCount(2, $roomType2->roomsAppliesTo->roomRequest);

        $this->assertCount(2, $roomType2->supplements);
        $this->assertCount(2, $roomType2->specialOffers);
        $this->assertCount(2, $roomType2->taxes);
        $this->assertCount(2, $roomType2->cancellationPolicies);

        return $roomType2;
    }

    /**
     * @test
     * @depends roomType1
     */
    public function oneRoonTypeOnly($roomType)
    {
        $oneRoomTypeOnly = new RoomTypes($roomType);

        $this->assertCount(1, $oneRoomTypeOnly, 'it only has one element');

        $this->assertSame($roomType, $oneRoomTypeOnly[0]);

        return $oneRoomTypeOnly;
    }

    /**
     * @test
     * @depends roomType1
     * @depends roomType2
     */
    public function twoRoonTypes($roomType1, $roomType2)
    {
        $twoRoomTypes = new RoomTypes($roomType1, $roomType2);

        $this->assertCount(2, $twoRoomTypes, 'it has two room types');

        $this->assertSame($roomType1, $twoRoomTypes[0]);
        $this->assertSame($roomType2, $twoRoomTypes[1]);

        return $twoRoomTypes;
    }

    /**
     * @test
     */
    public function image()
    {
        $image1000 = new Image(
            'CMSImage_1000.jpg',
            'CMSImageThumb_1000.jpg'
        );

        $this->assertSame('CMSImage_1000.jpg', $image1000->fullSize);
        $this->assertSame('CMSImageThumb_1000.jpg', $image1000->thumbnail);

        return $image1000;
    }

    /**
     * @test
     * @depends image
     */
    public function oneImageOnly($image)
    {
        $oneImageOnly = new Images($image);

        $this->assertCount(1, $oneImageOnly, 'it only has one element');

        $this->assertSame($image, $oneImageOnly[0]);

        return $oneImageOnly;
    }

    /**
     * @test
     * @depends image
     */
    public function twoImages($image)
    {
        $imageTwo = new Image(
            'CMSImage_1001.jpg',
            'CMSImageThumb_1001.jpg'
        );

        $twoImages = new Images(
            $image,
            $imageTwo
        );

        $this->assertCount(2, $twoImages, 'it has two elements');

        $this->assertSame($image, $twoImages[0]);
        $this->assertSame($imageTwo, $twoImages[1]);

        return $twoImages;
    }

    /**
     * @test
     */
    public function erratum()
    {
        $erratum = new Erratum(
            '2020-08-04',
            '2020-08-11',
            'Small pool will be closed for maintenance'
        );

        $this->assertSame('2020-08-04', $erratum->startDate);
        $this->assertSame('2020-08-11', $erratum->endDate);
        $this->assertSame('Small pool will be closed for maintenance', $erratum->description);

        return $erratum;
    }

    /**
     * @test
     * @depends erratum
     */
    public function oneErratumOnly($erratum)
    {
        $oneErratumOnly = new Errata($erratum);

        $this->assertCount(1, $oneErratumOnly, 'it only has one element');

        $this->assertSame($erratum, $oneErratumOnly[0]);

        return $oneErratumOnly;
    }

    /**
     * @test
     * @depends erratum
     */
    public function twoErrata($erratum)
    {
        $erratumTwo = new Erratum(
            '2020-08-04',
            '2020-08-11',
            'There won\'t be mayonese at the restaurant'
        );

        $twoErrata = new Errata(
            $erratum,
            $erratumTwo
        );

        $this->assertCount(2, $twoErrata, 'it has two elements');

        $this->assertSame($erratum, $twoErrata[0]);
        $this->assertSame($erratumTwo, $twoErrata[1]);

        return $twoErrata;
    }

    /**
     * @test
     */
    public function supplier()
    {
        $supplier = new Supplier(
            6,
            'RMI'
        );

        $this->assertSame(6, $supplier->supplierID);
        $this->assertSame('RMI', $supplier->supplierName);

        return $supplier;
    }

    /**
     * @test
     * @depends oneRoonTypeOnly
     * @depends oneImageOnly
     * @depends oneErratumOnly
     * @depends supplier
     */
    public function oneRoomProperty($oneRoonTypeOnly, $oneImageOnly, $oneErratumOnly, $supplier)
    {
        $propertyResult = new PropertyResult(
            99,
            $oneRoonTypeOnly,
            'Example Island',
            99999,
            'USD',
            4.5,
            6,
            10,
            22,
            'West Indies',
            'St Vincent & Grenadines',
            'Example Island',
            null,
            null,
            null,
            null,
            null,
            null,
            'Intimate, exotic and all-inclusive',
            'Example Island, a high-end luxury resort',
            'https://xmlhost/custom/content/',
            'CMSImage_999.jpg',
            'CMSImageThumb_999.jpg',
            $oneImageOnly,
            $oneErratumOnly,
            $supplier
        );

        $this->assertSame(99, $propertyResult->propertyID);
        $this->assertCount(1, $propertyResult->roomTypes);
        $this->assertSame('Example Island', $propertyResult->propertyName);
        $this->assertSame(99999, $propertyResult->gIATAID);
        $this->assertSame('USD', $propertyResult->currency);
        $this->assertSame(4.5, $propertyResult->rating);
        $this->assertCount(1, $propertyResult->images);
        $this->assertCount(1, $propertyResult->errata);

        $this->assertSame(6, $propertyResult->supplier->supplierID);
        $this->assertSame('RMI', $propertyResult->supplier->supplierName);

        return $propertyResult;
    }

    /**
     * @test
     * @depends twoRoonTypes
     * @depends twoImages
     * @depends twoErrata
     * @depends supplier
     */
    public function twoRoomProperty($twoRoonTypes, $twoImages, $twoErrata, $supplier)
    {
        $propertyResult = new PropertyResult(
            99,
            $twoRoonTypes,
            'Example Island',
            99999,
            'USD',
            4.5,
            6,
            10,
            22,
            'West Indies',
            'St Vincent & Grenadines',
            'Example Island',
            null,
            null,
            null,
            null,
            null,
            null,
            'Intimate, exotic and all-inclusive',
            'Example Island, a high-end luxury resort',
            'https://xmlhost/custom/content/',
            'CMSImage_999.jpg',
            'CMSImageThumb_999.jpg',
            $twoImages,
            $twoErrata,
            $supplier
        );

        $this->assertSame(99, $propertyResult->propertyID);
        $this->assertCount(2, $propertyResult->roomTypes);
        $this->assertSame('Example Island', $propertyResult->propertyName);
        $this->assertSame(99999, $propertyResult->gIATAID);
        $this->assertSame('USD', $propertyResult->currency);
        $this->assertSame(4.5, $propertyResult->rating);
        $this->assertCount(2, $propertyResult->images);
        $this->assertCount(2, $propertyResult->errata);

        $this->assertSame(6, $propertyResult->supplier->supplierID);
        $this->assertSame('RMI', $propertyResult->supplier->supplierName);

        return $propertyResult;
    }

    /**
     * @test
     * @depends oneRoomProperty
     */
    public function onePropertyResultsOnly($oneRoomProperty)
    {
        $propertyResults = new PropertyResults(1, $oneRoomProperty);

        $this->assertCount(1, $propertyResults);

        $this->assertSame(1, $propertyResults->totalProperties);

        $this->assertSame($oneRoomProperty, $propertyResults[0]);

        return $propertyResults;
    }

    /**
     * @test
     * @depends oneRoomProperty
     * @depends twoRoomProperty
     */
    public function twoPropertyResults($oneRoomProperty, $twoRoomProperty)
    {
        $propertyResults = PropertyResults::fromPropertyResults($oneRoomProperty, $twoRoomProperty);

        $this->assertCount(2, $propertyResults);

        $this->assertSame(2, $propertyResults->totalProperties);

        $this->assertSame($oneRoomProperty, $propertyResults[0]);
        $this->assertSame($twoRoomProperty, $propertyResults[1]);

        return $propertyResults;
    }
}