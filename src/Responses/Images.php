<?php


namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

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