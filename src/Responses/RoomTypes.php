<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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