<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

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