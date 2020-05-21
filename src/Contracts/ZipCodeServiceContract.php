<?php

namespace ZipCode\Contracts;

use ZipCode\Models\Address;

interface ZipCodeServicesContract
{
    public function fetchData(string $zipCode): Address;
}
