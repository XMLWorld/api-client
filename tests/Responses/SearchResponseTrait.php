<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\SearchResponse;

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