<?php 

namespace ZipCode;

require_once __DIR__ . '/../vendor/autoload.php';
use ZipCode\Services\Correios;

class ZipCodeSearcher 
{
    private $city;
    private $correio;
    private $neighborhood;
    private $street;
    private $state;
    private $status;

    public function find(int $zipCode)
    {
        $this->correio = new Correios($zipCode);
        $xmlResponse = $this->correio->fetchData();
        $this->setFieldsValues($xmlResponse);

        return $this->getFields();
    }

    private function setFieldsValues($xml) : void 
    {
        $this->city         = $xml['cidade'];
        $this->neighborhood = $xml['bairro'];
        $this->street       = $xml['end'];
        $this->state        = $xml['uf'];
        $this->status       = $xml['status'];
    } 

    public function getFields() : object 
    {    
        $fields = 
                [
                'street'       => $this->street,
                'city'         => $this->city,
                'state'        => $this->state,
                'neighborhood' => $this->neighborhood,
                'status'       =>$this->status
                ];

        return (object) $fields;
    } 
}

$x = new ZipCodeSearcher();

$object = $x->find(75712480);

echo $object->street.$object->status;