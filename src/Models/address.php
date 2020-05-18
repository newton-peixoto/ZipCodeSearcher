<?php

namespace ZipCode\Models;

class Address
{
    private $status;
    private $street;
    private $city;
    private $state;
    private $neighborhood;

    function __construct(
        $status,
        $street,
        $city,
        $state,
        $neighborhood
    ) {
        $this->status = $status;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->neighborhood = $neighborhood;
    }

    //get
    public function getStatus()
    {
        return $this->status;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    //set
    public function setStatus($status)
    {
        $this->$status = $status;
    }

    public function setStreet($street)
    {
        $this->$street = $street;
    }

    public function setCity($city)
    {
        $this->$city = $city;
    }

    public function setState($state)
    {
        $this->$state = $state;
    }

    public function setNeighborhood($neighborhood)
    {
        $this->$neighborhood = $neighborhood;
    }

    //magic
    public function __get(string $attributeName)
    {
        $method = 'get' . ucfirst($attributeName);
        return $this->$method();
    }

    public function __toString()
    {
        $str = $this->street . ', ';
        $str .= $this->neighborhood . ', ';
        $str .= $this->city . ' - ';
        $str .= $this->state . '.';

        return $str;
    }
}
