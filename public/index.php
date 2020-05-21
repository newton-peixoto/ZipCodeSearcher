<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZipCode\Services\Correios;
use ZipCode\ZipCodeSearcher;

$correios = new Correios;
$x = new ZipCodeSearcher($correios);
$x->find('75710808');

echo $x->address;
