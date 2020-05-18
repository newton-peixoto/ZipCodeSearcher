<?php

namespace ZipCode;

require_once __DIR__ . '/../vendor/autoload.php';

use stdClass;
use ZipCode\Models\Address;
use ZipCode\Services\Correios;

class ZipCodeSearcher
{
    private $address;

    function __construct(int $zipCode)
    {
        $this->correio = new Correios($zipCode);
        $xmlResponse = $this->correio->fetchData();
        $this->setFieldsValues($xmlResponse);
    }

    private function setFieldsValues($xml): void
    {
        $this->address = new Address(
            $xml['status'],
            $xml['end'] ?? null,
            $xml['cidade'] ?? null,
            $xml['uf']     ?? null,
            $xml['bairro'] ?? null
        );
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function __get(string $attributeName)
    {
        $method = 'get' . ucfirst($attributeName);
        return $this->$method();
    }
}

$x = new ZipCodeSearcher(75710808);

echo $x->address->status;
