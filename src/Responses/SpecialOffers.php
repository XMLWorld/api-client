<?php

namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

/**
 * @extends CommonCollection<SpecialOffer>
 */
class SpecialOffers extends CommonCollection
{
	public function __construct(
		SpecialOffer ...$specialOffer
	) {
		$this->data = $specialOffer;
	}
}