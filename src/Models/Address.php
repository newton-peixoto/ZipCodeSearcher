<?php

namespace ZipCode\Models;

class Address
{
    private $street = 'not found';
    private $city = 'not found';
    private $state = 'not found';
    private $neighborhood = 'not found';
    private $latitude = 'not found';
    private $longitude = 'not found';

    public function setAttributes(
        $street,
        $city,
        $state,
        $neighborhood,
        $latitude,
        $longitude
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->neighborhood = $neighborhood;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

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

    private static function getToStringAttribute($attribute, $complement)
    {
        return !empty($attribute) ? $attribute . $complement : '';
    }

    public function __toString()
    {
        $str = self::getToStringAttribute($this->street, ', ');
        $str .= self::getToStringAttribute($this->neighborhood, ', ');
        $str .= self::getToStringAttribute($this->city, ' - ');
        $str .= self::getToStringAttribute($this->state, '. ');

        $str .= self::getToStringAttribute($this->latitude, ', ');
        $str .= self::getToStringAttribute($this->longitude, '.');

        return $str;
    }
}
