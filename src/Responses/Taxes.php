<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

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