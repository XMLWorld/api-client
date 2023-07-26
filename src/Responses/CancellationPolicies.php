<?php


namespace XmlWorld\ApiPackagePhp\Responses;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

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