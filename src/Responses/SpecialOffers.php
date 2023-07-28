<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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