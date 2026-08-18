<?php

namespace XMLWorld\ApiClient\Requests;

class RoomRequest extends AbstractRequest
{
	public function __construct(
		public ?int $adults = null,
		public ?int $children = 0,
        public ?int $infants = 0,
		public ?ChildAges $childAges = null
	){}

	public static function fromAges(?int $adults, int ...$ages) : self
    {
        $childAges = null;

        $adults = $adults ?? 0;
        $children = count($ages);

        //if no children and not adults given...
        if(!$adults && !$children) {
            //we throw exception.
            throw new \InvalidArgumentException('At least one Adult or Child must be specified');
        }

        if(count($ages)){
            $childAges = ChildAges::fromAges(...$ages);
        }

        return new self(
            $adults,
            $children,
            null, //we are deprecating infants
            $childAges
		);
	}
}