<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

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