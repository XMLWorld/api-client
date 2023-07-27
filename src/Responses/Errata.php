<?php


namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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