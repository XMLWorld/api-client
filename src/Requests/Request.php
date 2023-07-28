<?php

namespace xmlworld\apiclient\Requests;

class Request extends AbstractRequest
{
    public function __construct(
    	public LoginDetails $loginDetails,
		public ?bool $mock = null
	) {}
}
