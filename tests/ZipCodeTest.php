<?php

use PHPUnit\Framework\TestCase;
use ZipCode\ZipCode;
use ZipCode\ZipCodeSearcher;

class ZipCodeTest extends TestCase {

    public function testZipCodeMustReturnAZipCodeSearcher()
    {
        $searcher = ZipCode::getSearcher('BR');

        return self::assertInstanceOf(ZipCodeSearcher::class, $searcher);
    }
}