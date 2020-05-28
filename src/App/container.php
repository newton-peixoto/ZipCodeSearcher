<?php


use League\Container\Container;
use ZipCode\Models\Address;
use ZipCode\Services\Correios;
use ZipCode\ZipCodeSearcher;

$container = new Container;

$container->add('ZipCodeService', function () {
    return  new ZipCodeSearcher(new Correios(new Address));
});


return $container;
