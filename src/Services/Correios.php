<?php

namespace ZipCode\Services;

use ZipCode\Contracts\ZipCodeServicesContract;
use ZipCode\Models\Address;

class Correios implements ZipCodeServicesContract
{
    private $xml;
    private $url;
    private $header;

    public function __construct()
    {
        $this->url = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente';
        $this->header = array('text/xml;charset=UTF-8', 'cache-control:no-cache');
        $this->address = new Address;
    }

    public function fetchData($zipCode): Address
    {
        $this->setXml($zipCode);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch)['http_code'];
        curl_close($ch);
        $result = utf8_encode($result);

        $xml = $this->parseStringAsArray($result, $httpCode);
        $this->address->setAttributes(
            $xml['status'],
            $xml['end'] ?? null,
            $xml['cidade'] ?? null,
            $xml['uf']     ?? null,
            $xml['bairro'] ?? null
        );

        return $this->address;
    }

    private function setXml($zipCode)
    {
        $this->xml = <<<XML
        <?xml version='1.0'?>
        <soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' 
          xmlns:cli='http://cliente.bean.master.sigep.bsb.correios.com.br/'>
          <soapenv:Header/>
          <soapenv:Body>
            <cli:consultaCEP>
              <cep>{$zipCode}</cep>
            </cli:consultaCEP>
          </soapenv:Body>
        </soapenv:Envelope>
        XML;
    }

    private function parseStringAsArray($xmlString, $httpCode)
    {
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'NS2:'], '', $xmlString);
        $xml       = simplexml_load_string($clean_xml);

        return $this->addStatusField($xml, $httpCode);
    }

    private function addStatusField($xml, $httpCode)
    {
        if ($httpCode == 200) {
            $xml->Body->consultaCEPResponse->return->addChild('status');
            $xml->Body->consultaCEPResponse->return->status = $httpCode;

            return (array) $xml->Body->consultaCEPResponse->return;
        } else {
            $xml->Body->Fault->addChild('status');
            $xml->Body->Fault->status = $httpCode;
            return (array)  $xml->Body->Fault;
        }
    }
}
