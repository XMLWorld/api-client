<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\Properties;

trait PropertiesTrait
{
    public function testOneProperty()
    {
        $instance = new Properties(2007);

        $expected = '<Properties>
				<PropertyID>2007</PropertyID>
			</Properties>';

        $this->doTest($instance, $expected, $expected);

        return [
            $instance,
            $expected,
            $expected
        ];
    }

    public function testTwoProperties()
    {
        $instance = new Properties(2007, 3008);

        $expected = '<Properties>
				<PropertyID>2007</PropertyID>
				<PropertyID>3008</PropertyID>
			</Properties>';

        $this->doTest($instance, $expected, $expected);

        return [
            $instance,
            $expected,
            $expected
        ];
    }
}