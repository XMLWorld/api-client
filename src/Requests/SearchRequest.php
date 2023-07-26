<?php


namespace XmlWorld\ApiPackagePhp\Requests;

class SearchRequest extends Request
{
	public function __construct(
		LoginDetails $loginDetails,
		public SearchDetails $searchDetails,
		?bool $mock = null
	){
		parent::__construct($loginDetails, $mock);
	}
}