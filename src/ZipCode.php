<?php

namespace ZipCode;

require_once __DIR__ . '/../vendor/autoload.php';

use ZipCode\Contracts\ZipCodeServiceContract;
use ZipCode\ZipCodeSearcher;
use ZipCode\Services\Zippopotamus;

class ZipCode
{
    public static function getSearcher($countryTag = 'BR'): ZipCodeSearcher
    {
        $dice = require_once __DIR__ . '../../src/App/container.php';

        $dice = self::setService($dice, $countryTag);
        
        return $dice->create(ZipCodeSearcher::class);
    }

    private static function setService($dice, $countryTag)
    {

        switch ($countryTag) {
            case 'BR':
                break;
            default:
                $dice = $dice->addRules([
                    ZipCodeSearcher::class => [
                        'substitutions' => [
                            ZipCodeServiceContract::class => Zippopotamus::class
                        ],
                    ],
                    Zippopotamus::class => ['constructParams' => [$countryTag]]
                ]);
                break;
        }

        return $dice;        
    }
}
