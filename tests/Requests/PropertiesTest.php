<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\Properties;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class PropertiesTest extends BaseSerializeXML
{
    public function testOneProperty()
    {
        $proeprtyID = new Properties(2007);

        $expected = '<Properties>
				<PropertyID>2007</PropertyID>
			</Properties>';

        $this->serialize(
            $expected,
            $proeprtyID
        );

        $this->unserialize(
            $expected,
            $proeprtyID
        );

        return $proeprtyID;
    }

    public function testTwoProperties()
    {
        $twoPropertyIDs = new Properties(2007, 3008);
        $expected = '<Properties>
				<PropertyID>2007</PropertyID>
				<PropertyID>3008</PropertyID>
			</Properties>';

        $this->serialize(
            $expected,
            $twoPropertyIDs
        );

        $this->unserialize(
            $expected,
            $twoPropertyIDs
        );

        return $twoPropertyIDs;
    }
}