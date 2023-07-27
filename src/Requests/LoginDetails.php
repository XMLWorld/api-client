<?php

namespace XmlWorld\ApiClient\Requests;

class LoginDetails extends AbstractRequest
{
    public function __construct(
    	public string $login,
		public string $password,
		public string $version
	) {}
}
