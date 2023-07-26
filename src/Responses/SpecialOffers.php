<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

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