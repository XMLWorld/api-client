<?php

namespace XmlWorld\ApiClient\Requests;

use XmlWorld\ApiClient\Classes\CommonCollection;

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