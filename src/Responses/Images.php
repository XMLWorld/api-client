<?php


namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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