<?php


namespace XmlWorld\ApiPackagePhp\Common;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

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