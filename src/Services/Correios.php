<?php

namespace ZipCode\Services;
use SimpleXMLElement;

class Correios
{
    private $xml;
    private $url;
    private $header;

    public function __construct($zipCode)
    {
        $this->setXml($zipCode);
        $this->url = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente';
        $this->header = array('text/xml;charset=UTF-8', 'cache-control:no-cache');
    }

    public function fetchData()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        $result = curl_exec($ch);
        curl_close($ch);
        
        return $this->parseStringAsXmlObject(utf8_encode($result));
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

    private function parseStringAsXmlObject($xmlString) : SimpleXMLElement
    {
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:','NS2:'], '', $xmlString);
        $xml       = simplexml_load_string($clean_xml);

        return $xml->Body->consultaCEPResponse->return;
    }
}