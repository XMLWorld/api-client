<?php


namespace XmlWorld\ApiPackagePhp\Requests;

class BookRequest extends Request
{
	public function __construct(
		LoginDetails $loginDetails,
		public BookDetails $bookDetails,
		?bool $mock = null
	){
		parent::__construct($loginDetails, $mock);
	}
}