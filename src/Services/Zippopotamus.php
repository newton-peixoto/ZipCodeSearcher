<?php

namespace ZipCode\Services;

use ZipCode\Contracts\ZipCodeServiceContract;
use ZipCode\Models\Address;

class Zippopotamus implements ZipCodeServiceContract
{

    private $address;
    private $baseUrl;
    private $country;
    private $zipCode;

    public function __construct(Address $address, $country)
    {
        $this->address = $address;
        $this->country = $country;
        $this->baseUrl = 'http://api.zippopotam.us/';
    }

    public function fetchData($zipCode): Address
    {
        $this->setZipCode($zipCode);
        $ch = $this->getCurl();
        $this->setAddressFromCurlResult($ch);

        return $this->address;
    }

    private function getCurl()
    {
        $ch = curl_init($this->GetUrl());
        curl_setopt($ch, CURLOPT_URL, $this->GetUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        return $ch;
    }

    private function setAddressFromCurlResult($ch)
    {
        $result = curl_exec($ch);
        $result = json_decode($result);

        $this->normalizeAddress($result);
    }

    private function normalizeAddress($result) {
        $count = count(get_object_vars($result));

        if( $count != 0 )
        {   
            $this->address->setAttributes(
                null,
                $result->places[0]->{'place name'} ,
                $result->places[0]->{'state'},
                null,
                $result->places[0]->{'latitude'},
                $result->places[0]->{'longitude'}
            );
        }
    }

    private function getUrl()
    {
        return $this->baseUrl . $this->country . '/' . $this->zipCode;
    }

    private function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
}
