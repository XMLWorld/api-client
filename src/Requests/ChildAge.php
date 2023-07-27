<?php

namespace XmlWorld\ApiClient\Requests;

class ChildAge extends AbstractRequest
{
	public function __construct(
		public int $age
	){}
}