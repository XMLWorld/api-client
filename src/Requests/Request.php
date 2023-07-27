<?php

namespace XmlWorld\ApiClient\Requests;

class Request extends AbstractRequest
{
    public function __construct(
    	public LoginDetails $loginDetails,
		public ?bool $mock = null
	) {}
}
