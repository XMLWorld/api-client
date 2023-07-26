<?php


namespace XmlWorld\ApiPackagePhp\Responses;

class RoomsAppliesTo extends AbstractResponse
{
	/** @var int[]  */
	public array $roomRequest;

	public function __construct(
		int ...$roomRequest
	){
		$this->roomRequest = $roomRequest;
	}
}