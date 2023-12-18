<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

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