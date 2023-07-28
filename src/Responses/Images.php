<?php


namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

/**
 * @extends CommonCollection<Image>
 */
class Images extends CommonCollection
{
	public function __construct(
		Image ...$image
	) {
		$this->data = $image;
	}
}