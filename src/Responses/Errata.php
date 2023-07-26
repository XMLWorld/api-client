<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

/**
 * @extends CommonCollection<Erratum>
 */
class Errata extends CommonCollection
{
	public function __construct(
		Erratum ...$erratum
	) {
		$this->data = $erratum;
	}
}