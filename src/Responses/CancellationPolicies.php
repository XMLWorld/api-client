<?php

namespace XmlWorld\ApiClient\Responses;

use XmlWorld\ApiClient\Classes\CommonCollection;

/**
 * @extends CommonCollection<CancellationPolicy>
 */
class CancellationPolicies extends CommonCollection
{
	public function __construct(
		CancellationPolicy ...$cancellationPolicy
	) {
		$this->data = $cancellationPolicy;
	}
}