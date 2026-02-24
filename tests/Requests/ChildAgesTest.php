<?php

namespace XMLWorld\ApiClient\Test\Requests;

use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

/**
 * @method testChildAge
 * @method testTwoChildAges
 */
class ChildAgesTest extends BaseSerializeXML
{
    use ChildAgesTrait;
}