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
		list($onePropertyResultInstance,	$onePropertyResultSerialize,	$onePropertyResultUnserialize)	= $this->getOnePropertyResult($this->getPropertyResult1());


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

	protected function getSearchResponseTwoProperties()
	{
		list($requestInfoInstance, 			$requestInfoSerialize, 			$requestInfoUnserialize) 		= $this->getResponseInfo();
		list($returnStatusTrueInstance,		$returnStatusTrueSerialize,		$returnStatusTrueUnserialize)	= $this->getReturnStatusTrue();
		list($twoPropertyResultInstance,	$twoPropertyResultSerialize,	$twoPropertyResultUnserialize)	= $this->getTwoPropertyResults($this->getPropertyResult1(), $this->getPropertyResult2());

		$instance = new SearchResponse(
			$requestInfoInstance,
			$returnStatusTrueInstance,
			$twoPropertyResultInstance
		);

		$serialize = <<<XML
<SearchResponse>
	$requestInfoSerialize
	$returnStatusTrueSerialize
	$twoPropertyResultSerialize
</SearchResponse>
XML;

		$unserialize = <<<XML
<SearchResponse>
	$requestInfoUnserialize
	$returnStatusTrueUnserialize
	$twoPropertyResultUnserialize
</SearchResponse>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}
}