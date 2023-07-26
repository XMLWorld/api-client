<?php


namespace XmlWorld\ApiPackagePhp\Requests;


class ChildAge extends AbstractRequest
{
	public function __construct(
		public int $age
	){}
}