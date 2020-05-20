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

    //magic
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
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
