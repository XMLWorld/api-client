<?php
namespace XmlWorld\ApiPackagePhp\Responses;

class Response extends AbstractResponse
{
	public function __construct(
		public RequestInfo $requestInfo,
		public ReturnStatus $returnStatus
	) {}
}