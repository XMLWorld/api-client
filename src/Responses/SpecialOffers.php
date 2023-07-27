<?php

namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

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