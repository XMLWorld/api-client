<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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