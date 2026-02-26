<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\Properties;

trait PropertiesTrait
{
    protected function getOneProperty() : array
    {
        $instance = new Properties(2007);

        $serialize = <<<'XML'
<Properties>
	<PropertyID>2007</PropertyID>
</Properties>
XML;
		$unserialize = <<<'XML'
<Properties> <PropertyID>2007</PropertyID>
</Properties>
XML;


        return [
            $instance,
			$serialize,
			$unserialize
        ];
    }

	protected function getTwoProperties() : array
    {
        $instance = new Properties(2007, 3008);

		$serialize = <<<'XML'
<Properties>
	<PropertyID>2007</PropertyID>
	<PropertyID>3008</PropertyID>
</Properties>
XML;
		$unserialize = <<<'XML'
<Properties>
	<PropertyID>2007</PropertyID>
	<PropertyID>3008</PropertyID>
</Properties>
XML;
        return [
            $instance,
			$serialize,
			$unserialize
        ];
    }
}