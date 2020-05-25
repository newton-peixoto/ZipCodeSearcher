<?php

require_once __DIR__ . '../../../vendor/autoload.php';

use Dice\Dice;
use ZipCode\Contracts\ZipCodeServiceContract;
use ZipCode\Services\Correios;
use ZipCode\Services\Zippopotamus;
use ZipCode\ZipCodeSearcher;

$container = new Dice();

$container = $container->addRules([
    ZipCodeSearcher::class => [
        'substitutions' => [
            ZipCodeServiceContract::class => Correios::class
        ]
    ]
]);

return $container;
