<?php

namespace XmlWorld\ApiClient\Requests;

class RoomRequest extends AbstractRequest
{
	public function __construct(
		public ?int $adults = null,
		public ?int $children = null,
		public ?int $infants = null,
		public ?ChildAges $childAges = null
	){}

	public static function fromAges(?int $adults, int ...$ages) : self
	{
		$children = $infants = 0;
		$childrenAgeObject = null;

		$adults = $adults ?? 0;

		//we take the ages of children only
		$childrenAges = array_filter($ages, function($item){return $item > 2; });

		//if no children and not adults given...
		if($adults == 0 && count($childrenAges) == 0) {
			//we throw exception.
			throw new \InvalidArgumentException('At least one Adult or Child must be specified');
		}

		//if there are children or infants...
		if(count($ages) > 0) {
			//we calculate the number of Infants which are those children younger than 3
			$infants = count($ages) - count($childrenAges);

			//if there are children...
			if(count($childrenAges) > 0) {
				$children = count($childrenAges);

				$childrenAgeObject = ChildAges::fromAges(...$childrenAges);
			}
		}

		return new self(
			$adults,
			$children,
			$infants,
			$childrenAgeObject
		);
	}
}