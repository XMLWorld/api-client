<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

/**
 * @extends CommonCollection<Supplement>
 */
class Supplements extends CommonCollection
{
	public function __construct(
		Supplement ...$supplement
	) {
		$this->data = $supplement;
	}
}