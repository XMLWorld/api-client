<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SearchResponse;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

trait SearchResponseTrait
{
	use ResponseTrait;
	use PropertyResultTrait;

    protected function getSearchResponseOneProperty()
    {
		list($requestInfoInstance, 			$requestInfoSerialize, 			$requestInfoUnserialize) 		= $this->getResponseInfo();
		list($returnStatusTrueInstance,		$returnStatusTrueSerialize,		$returnStatusTrueUnserialize)	= $this->getReturnStatusTrue();
		list($onePropertyResultInstance,	$onePropertyResultSerialize,	$onePropertyResultUnserialize)	= $this->getOnePropertyResult();


		$instance = new SearchResponse(
			$requestInfoInstance,
			$returnStatusTrueInstance,
			$onePropertyResultInstance
        );

        $serialize = <<<XML
<SearchResponse>
	$requestInfoSerialize
	$returnStatusTrueSerialize
	$onePropertyResultSerialize
</SearchResponse>
XML;

        $unserialize = <<<XML
<SearchResponse>
	$requestInfoUnserialize
	$returnStatusTrueUnserialize
	$onePropertyResultUnserialize
</SearchResponse>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}