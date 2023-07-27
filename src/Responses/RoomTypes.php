<?php

namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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