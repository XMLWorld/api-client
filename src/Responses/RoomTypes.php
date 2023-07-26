<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

/**
 * @extends CommonCollection<RoomType>
 */
class RoomTypes extends CommonCollection
{
	public function __construct(
		RoomType ...$roomType
	) {
		$this->data = $roomType;
	}
}