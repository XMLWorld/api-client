<?php

namespace XMLWorld\ApiClient\Test;

use PHPUnit\Framework\TestCase;
use XMLWorld\ApiClient\Interfaces\Serializable;
use XMLWorld\ApiClient\Interfaces\Serializer;
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

    public function wrap($instance, string $serialize, ?string $userialize = null)
    {
        $class_name = substr(strrchr(get_class($instance), '\\'), 1);

        $serialize = "<{$class_name}>
				{$serialize}
			</{$class_name}>";

        if(is_null($userialize)){
            $userialize = $serialize;
        } else {
            $userialize = "<{$class_name}>
				{$userialize}
			</{$class_name}>";
        }

        return [
            $instance,
            $serialize,
            $userialize
        ];
    }

    public function doTest($instance, $serialized, $unserialized)
    {
        $this->serialize($serialized, $instance);

        $this->unserialize($unserialized, $instance);
    }
}