<?php

namespace Tests\Services;

use ZipCode\Services\Correios;
use PHPUnit\Framework\TestCase;

class CorreiosTest extends TestCase
{
    function testMustReturnHttp200IfZipCodeIsValid()
    {
        $correio = new Correios(75712480);
        $result  = $correio->fetchData();

        self::assertEquals($result['status'], 200);
    }

    function testMustReturnHttp500IfZipCodeIsInvalid()
    {
        $correio = new Correios(99999999);
        $result  = $correio->fetchData();

        self::assertEquals($result['status'], 500);
    }

    function testReturnOfFetchDataMustBeAnArray()
    {
        $correio = new Correios(75712480);
        $result  = $correio->fetchData();

        self::assertTrue(is_array($result));
    }
}
