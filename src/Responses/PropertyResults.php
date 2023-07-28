<?php


namespace xmlworld\apiclient\Responses;

use xmlworld\apiclient\Classes\CommonCollection;

/**
 * @extends CommonCollection<int|PropertyResult>
 */
class PropertyResults extends CommonCollection
{
	public function __construct(
		int $totalProperties,
		PropertyResult ...$propertyResult
	) {
		$this->data['TotalProperties'] = $totalProperties;
		$this->data += $propertyResult;
	}

	public static function fromPropertyResults(PropertyResult ...$propertyResult) : self
	{
		return new self(count($propertyResult), ...$propertyResult);
	}
}