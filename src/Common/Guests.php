<?php

namespace xmlworld\apiclient\Common;

use xmlworld\apiclient\Classes\CommonCollection;

/**
 * @extends CommonCollection<Guest>
 */
class Guests extends CommonCollection
{
	public function __construct(
		Guest ...$guest
	){
		$this->data = $guest;
	}
}