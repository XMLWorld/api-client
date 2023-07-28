<?php

namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

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