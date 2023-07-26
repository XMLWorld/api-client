<?php


namespace XmlWorld\ApiPackagePhp\Requests;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

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