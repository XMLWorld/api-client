<?php

namespace XMLWorld\ApiClient\Test;

use PHPUnit\Framework\TestCase;
use XMLWorld\ApiClient\Interfaces\Serializable;
use XMLWorld\ApiClient\Interfaces\Serializer;
use XMLWorld\ApiClient\Requests\AbstractRequest;
use XMLWorld\ApiClient\SerializeXML;
use ReflectionClass;

abstract class BaseSerializeXML extends TestCase
{
    protected static Serializer $serializer;

    public static function setUpBeforeClass(): void
    {
        self::$serializer = new SerializeXML;
    }

    public function serialize(string $expected, Serializable $obj)
    {
        $this->assertEquals(
            str_replace(["\r\n", "\n", "\t"], '', $expected),
            self::$serializer->serialize($obj)
        );
    }

    public function unserialize(string $xml, Serializable $expected)
    {
        $namespace = (new ReflectionClass($expected))->getNamespaceName();
        $this->assertEquals($expected, self::$serializer->unserialize($xml, $namespace));
    }
}