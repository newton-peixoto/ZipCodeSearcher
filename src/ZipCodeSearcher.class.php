<?php 

namespace ZipCode;

use ZipCode\Services\Correios;

//include_once('./Services/Correios.class.php');

class ZipCodeSearcher 
{
    private $city;
    private $correio;
    private $neighborhood;
    private $street;
    private $state;

    public function find(int $zipCode)
    {
        $this->correio = new Correios($zipCode);
        $xmlResponse = $this->correio->fetchData();
        $this->setFieldsValues($xmlResponse);

        return $this->getFields();
    }

    private function setFieldsValues($xml) : void 
    {
        $this->city         = $xml->cidade;
        $this->neighborhood = $xml->bairro;
        $this->street       = $xml->end;
        $this->state        = $xml->uf;
    } 

    public function getFields() : object 
    {    
        $fields = 
                [
                'street'       => $this->street,
                'city'         => $this->city,
                'state'        => $this->state,
                'neighborhood' => $this->neighborhood
                ];

        return (object) $fields;
    } 
}

$x = new ZipCodeSearcher();

$object = $x->find(75712480);

echo $object->street;
