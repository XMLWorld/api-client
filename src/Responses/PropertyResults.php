<?php


namespace XMLWorld\ApiClient\Responses;

use XMLWorld\ApiClient\Classes\CommonCollection;

/**
 * @extends CommonCollection<int|PropertyResult>
 */
class PropertyResults extends CommonCollection
{
	public function __construct(
		public int $totalProperties,
		PropertyResult ...$propertyResult
	) {
		//$this->data['TotalProperties'] = $totalProperties;
        //$this->data = [];
		$this->data = $propertyResult;
	}

    /** @return \ArrayIterator<int, T> */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator(['TotalProperties' => $this->totalProperties] + $this->data);
    }

    public function getPropertyResults() : array
    {
        return $this->data;
    }

	public static function fromPropertyResults(PropertyResult ...$propertyResult) : self
	{
		return new self(count($propertyResult), ...$propertyResult);
	}
}