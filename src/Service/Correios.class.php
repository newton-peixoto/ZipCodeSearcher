<?php

namespace ZipCode\Service;

class Correios
{
    private $xml;
    private $url;
    private $header;

    public function __construct($cep)
    {
        $this->setXml($cep);
        $this->url = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente';
        $this->header = array('Content-Type: text/plain', "cache-control:no-cache");
    }
    
    public function fetchData()
    {
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $this->url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $this->xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $this->header);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    private function setXml($cep)
    {
        $this->xml ='<?xml version="1.0"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cli="http://cliente.bean.master.sigep.bsb.correios.com.br/"><soapenv:Header/><soapenv:Body> <cli:consultaCEP><cep>75712480</cep></cli:consultaCEP> </soapenv:Body></soapenv:Envelope>';

    }
}

$correio = new Correios('75712480');

echo $correio->fetchData();