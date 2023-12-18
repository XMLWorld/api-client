<?php


namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

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