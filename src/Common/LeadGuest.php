<?php


namespace XmlWorld\ApiPackagePhp\Common;


use XmlWorld\ApiPackagePhp\Interfaces\Serializable;

class LeadGuest extends AbstractCommon
{
    public function __construct(
    	public string $firstName,
		public string $lastName,
		public string $title,
		public ?string $address1 = null,
		public ?string $address2 = null,
		public ?string $townCity = null,
		public ?string $county = null,
		public ?string $postcode = null,
		public ?string $phone = null,
		public ?string $email = null,
		public ?string $request = null,
	) {}
}
