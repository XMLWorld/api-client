<?php


namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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