<?php

namespace ZipCode;

use ZipCode\Contracts\ZipCodeServicesContract;
use ZipCode\Models\Address;


class ZipCodeSearcher
{
    private $address;
    private $zipCodeService;

    function __construct(ZipCodeServicesContract $zipCodeService)
    {
        $this->zipCodeService = $zipCodeService;
    }

    function find($zipCode)
    {
        $this->address = $this->zipCodeService->fetchData($zipCode);
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
