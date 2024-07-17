<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ErrataTest extends BaseSerializeXML
{
    public function testErratum()
    {
        $erratum = new Erratum(
            '2020-08-04',
            '2020-08-11',
            'Small pool will be closed for maintenance'
        );

        $this->serialize(
            '<Erratum>
				<StartDate>2020-08-04</StartDate>
				<EndDate>2020-08-11</EndDate>
				<Description>Small pool will be closed for maintenance</Description>
			</Erratum>',
            $erratum
        );

        $this->unserialize(
            '<Erratum>
				<StartDate>2020-08-04</StartDate>
				<EndDate>2020-08-11</EndDate>
				<Description>Small pool will be closed for maintenance</Description>
			</Erratum>',
            $erratum
        );

        return $erratum;
    }


    /**
     * @depends testErratum
     */
    public function testOneErrata($erratum)
    {
        $oneErratum = new Errata($erratum);

        $this->serialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
            $oneErratum
        );

        $this->unserialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
            $oneErratum
        );

        return $oneErratum;
    }

    /**
     * @depends testErratum
     */
    public function testTwoErrata($erratum)
    {
        $twoErrata = new Errata(
            $erratum,
            new Erratum(
                '2020-08-04',
                '2020-08-11',
                'There won\'t be mayonese at the restaurant'
            )
        );

        $this->serialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>There won\'t be mayonese at the restaurant</Description>
				</Erratum>
			</Errata>',
            $twoErrata
        );

        $this->unserialize(
            '<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>There won\'t be mayonese at the restaurant</Description>
				</Erratum>
			</Errata>',
            $twoErrata
        );

        return $twoErrata;
    }

}