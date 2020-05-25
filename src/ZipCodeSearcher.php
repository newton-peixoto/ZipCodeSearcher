<?php

namespace ZipCode;

use stdClass;
use ZipCode\Contracts\ZipCodeServiceContract;

class ZipCodeSearcher
{
    private $address;
    private $webService;

    public function __construct(ZipCodeServiceContract $webService)
    {
        $this->webService = $webService;
    }

    function find(string $zipCode)
    {
        $this->address = $this->webService->fetchData($zipCode);

        return $this->address;
    }
    
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
