<?php


namespace XmlWorld\ApiPackagePhp\Responses;


class RequestInfo extends AbstractResponse
{
	public function __construct(
		public int $timestamp,
		public string $timestampISO,
		public string $host,
		public string $hostIP,
		public string $reqID
	) {}
}