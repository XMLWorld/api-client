<?php

namespace XMLWorld\ApiClient\Requests;

use XMLWorld\ApiClient\Classes\CommonCollection;

/**
 * @extends CommonCollection<RoomRequest>
 */
class RoomRequests extends CommonCollection
{
	public function __construct(
		RoomRequest ...$roomRequest
	) {
		$this->data = $roomRequest;
	}
}