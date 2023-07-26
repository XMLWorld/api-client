<?php


namespace XmlWorld\ApiPackagePhp\Interfaces;

interface Serializer
{
	public function serialize(Serializable $serializableObject) : string;

	public function unSerialize(string $payload) : Serializable;
}