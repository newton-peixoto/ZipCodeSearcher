<?php 

namespace Tests\Services;

use ZipCode\ZipCodeSearcher;
use PHPUnit\Framework\TestCase;
use ZipCode\Models\Address;
use ZipCode\Services\Correios;

class ZipCodeSearcherTest extends TestCase 
{
    public function testAdressAttributeMustBeAnInstanceOfModelAdress()
    {
        $zipCode = new ZipCodeSearcher(75712480);

        self::assertInstanceOf(Address::class, $zipCode->address);
    }
    
    public function testCorreioAttributeMustBeAnInstanceOfCorreiosService()
    {
        $zipCode = new ZipCodeSearcher(75712480);

        self::assertInstanceOf(Correios::class, $zipCode->correio);
    }
}