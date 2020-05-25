<?php

namespace ZipCode\Contracts;

use ZipCode\Models\Address;

interface ZipCodeServiceContract
{
    public  function fetchData($zipCode): Address;
}
