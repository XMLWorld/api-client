<?php

namespace XMLWorld\ApiClient\Requests;

class RoomRequest extends AbstractRequest
{
	public function __construct(
		public ?int $adults = null,
		public ?int $children = null,
		public ?ChildAges $childAges = null
	){}

	public static function fromAges(?int $adults, int ...$ages) : self
	{
		$adults = $adults ?? 0;

		//if no children and not adults given...
		if($adults == 0 && count($ages) == 0) {
			//we throw exception.
			throw new \InvalidArgumentException('At least one Adult or Child must be specified');
		}

		return new self(
			$adults,
            count($ages),
            ChildAges::fromAges(...$ages)
		);
	}
}