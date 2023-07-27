<?php

namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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