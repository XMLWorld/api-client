<?php

namespace XmlWorld\ApiClient\Common;

use XmlWorld\ApiClient\Classes\CommonCollection;

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