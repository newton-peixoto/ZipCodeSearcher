<?php

namespace ZipCode\Services;

use ZipCode\Contracts\ZipCodeServiceContract;
use ZipCode\Models\Address;

class Correios implements ZipCodeServiceContract
{
    private $xml;
    private $url;
    private $header;

    public function __construct(Address $address)
    {
        $this->url = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente';
        $this->header = array('text/xml;charset=UTF-8', 'cache-control:no-cache');
        $this->address = $address;
    }

    private function getCurl()
    {
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

        return $ch;
    }

    private static function getCurlResult($ch) : array
    {
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch)['http_code'];
        curl_close($ch);
        $result = utf8_encode($result);
        return ['result' => $result, 'http_code' => $httpCode];
    }

    public function fetchData($zipCode): Address
    {
        $this->setXml($zipCode);
        $ch = $this->getCurl();
        $curlResult = self::getCurlResult($ch);
        $result = $curlResult['result'];
        $httpCode = $curlResult['http_code'];

        $xml = self::parseXmlString($result);
        $arrayXml = self::getCompleteXmlAsArray($xml, $httpCode);
        
        if ( !isset($arrayXml['faultstring']) )
        {
            $this->address->setAttributes(
                $arrayXml['end'],
                $arrayXml['cidade'],
                $arrayXml['uf'],      
                $arrayXml['bairro'], 
                null,
                null,);
        }

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

    private static function parseXmlString($xmlString)
    {
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'NS2:'], '', $xmlString);
        return simplexml_load_string($clean_xml);
    }

    private static function getCompleteXmlAsArray($xml, $httpCode)
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
