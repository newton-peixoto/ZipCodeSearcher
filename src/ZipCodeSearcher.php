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

    public function find(int $zipCode)
    {
        $this->correio = new Correios($zipCode);
        $xmlResponse = $this->correio->fetchData();
        $this->setFieldsValues($xmlResponse);

        return $this->getFields();
    }

    private function setFieldsValues($xml) : void 
    {
        $this->city         = $xml->cidade ?? null;
        $this->neighborhood = $xml->bairro ?? null;
        $this->street       = $xml->end    ?? null;
        $this->state        = $xml->uf     ?? null;
        $this->status       = $xml->faultstring ?? ''
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

$object = $x->find(75712488);

echo $object->street;
