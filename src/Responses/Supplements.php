<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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