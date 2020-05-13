<?php 

namespace ZipCode;

class ZipCodeSearcher 
{
    private $cep;

    public function __construct($cep)
    {
        $this->cep = $cep;
    }
}