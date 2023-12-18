<?php


namespace XMLWorld\ApiClient\Responses;

class Image extends AbstractResponse
{
	public function __construct(
		public string $fullSize,
		public string $thumbnail,
	){}
}