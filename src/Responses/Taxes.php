<?php

namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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