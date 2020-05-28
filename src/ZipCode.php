<?php

namespace ZipCode;

require_once __DIR__ . '/../vendor/autoload.php';

use ZipCode\Models\Address;
use ZipCode\ZipCodeSearcher;
use ZipCode\Services\Zippopotamus;

class ZipCode
{
    public static function getSearcher($countryTag = 'BR'): ZipCodeSearcher
    {

        $container = require_once __DIR__ . '../App/container.php';
        $container = $countryTag != 'BR' ? self::getNewService($container, $countryTag) : $container;

        return $container->get(self::getRightService($countryTag));
    }

    private static function getNewService($container, $countryTag)
    {
        $container->add('ZipCodeServiceAll', function () use ($countryTag) {
            return  new ZipCodeSearcher(new Zippopotamus(new Address, $countryTag));
        });

        return $container;
    }

    private static function getRightService($countryTag)
    {
        return $countryTag != 'BR' ?  'ZipCodeServiceAll' : 'ZipCodeService';
    }
}
