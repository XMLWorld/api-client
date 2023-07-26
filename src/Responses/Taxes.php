<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

/**
 * @extends CommonCollection<Tax>
 */
class Taxes extends CommonCollection
{
	public function __construct(
		Tax ...$tax
	) {
		$this->data = $tax;
	}
}