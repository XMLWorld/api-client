<?php

namespace xmlworld\apiclient\Requests;

use xmlworld\apiclient\Classes\CommonCollection;

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