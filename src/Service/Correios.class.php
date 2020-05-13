<?php

namespace ZipCode\Service;

use XMLReader;

class Correios
{
    private $xml;
    private $url;
    private $header;

    public function __construct($cep)
    {
        $this->setXml($cep);
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
        echo curl_error($ch);
        curl_close($ch);
        return utf8_encode($result);
    }


    private function setXml($cep)
    {
        $this->xml = <<<XML
        <?xml version='1.0'?>
        <soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' 
          xmlns:cli='http://cliente.bean.master.sigep.bsb.correios.com.br/'>
          <soapenv:Header/>
          <soapenv:Body>
            <cli:consultaCEP>
              <cep>{$cep}</cep>
            </cli:consultaCEP>
          </soapenv:Body>
        </soapenv:Envelope>
        XML;
    }
}

$correio = new Correios('75710808');

var_dump($correio->fetchData());
