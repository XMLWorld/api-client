<?php

namespace XMLWorld\ApiClient\Common;

use XMLWorld\ApiClient\Classes\CommonCollection;

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