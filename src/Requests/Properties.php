<?php

namespace xmlworld\apiclient\Requests;

class Properties extends AbstractRequest
{
	/** @var int[]  */
	public array $propertyID;

	public function __construct(
		int ...$propertyID
	){
		$this->propertyID = $propertyID;
	}
}