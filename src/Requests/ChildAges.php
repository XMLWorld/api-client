<?php


namespace XmlWorld\ApiPackagePhp\Requests;

use XmlWorld\ApiPackagePhp\Classes\CommonCollection;

/**
 * @extends CommonCollection<ChildAge>
 */
class ChildAges extends CommonCollection
{
	public function __construct(
		ChildAge ...$childAge
	){
		$this->data = $childAge;
	}

	public static function fromAges(int ...$ages) : self
	{
		$chilAges = array_map(
			function($item){
				return new ChildAge($item);
			},
			$ages
		);

		return new self(...$chilAges);
	}
}