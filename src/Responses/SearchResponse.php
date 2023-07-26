<?php


namespace XmlWorld\ApiPackagePhp\Responses;


class SearchResponse extends Response
{
	public function __construct(
		RequestInfo $requestInfo,
		ReturnStatus $returnStatus,
		public ?PropertyResults $propertyResults = null
	){
		parent::__construct($requestInfo, $returnStatus);
	}
}
