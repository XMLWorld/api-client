<?php

namespace XMLWorld\ApiClient\Requests;

class ChildAge extends AbstractRequest
{
	public function __construct(
		public int $age
	){}
}