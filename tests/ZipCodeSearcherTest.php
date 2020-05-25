<?php

use PHPUnit\Framework\TestCase;
use ZipCode\Models\Address;
use ZipCode\ZipCode;

class ZipCodeSearcherTest extends TestCase
{
    public function testAfterFindAttributeAddressMustBeAnAddress()
    {
        $searcher = ZipCode::getSearcher('BR');
        $searcher->find('74989410');
        return self::assertInstanceOf(Address::class, $searcher->address);
    }

    public function testWhenAValidZipcodeIsPassedTheToStringAdressMustReturnTheCurrentAddress()
    {
        $searcher = ZipCode::getSearcher('US');
        $searcher->find('90210');
        self::assertEquals($searcher->address, 'Beverly Hills - California. 34.0901, -118.4065.');
    }

    public function testWhenAValidZipcodeIsPassedTheToStringAdressMustReturnTheCurrentAddressBr()
    {
        $searcher = ZipCode::getSearcher('BR');
        $searcher->find('74989410');
        self::assertEquals($searcher->address, 'Rua Lamartine Pinto A. Almeida, Rosa dos Ventos, Aparecida de Goiânia - GO. ');
    }

    public function testIfZipCodeIsNotFoundReturnNotFound()
    {
        $searcher = ZipCode::getSearcher('US');
        $searcher->find('7571-2488');
        return self::assertEquals($searcher->address, 'not found, not found, not found - not found. not found, not found.');
    }

}
