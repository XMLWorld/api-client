<?php

namespace xmlworld\apiclient\Requests;

class ChildAge extends AbstractRequest
{
	public function __construct(
		public int $age
	){}
}