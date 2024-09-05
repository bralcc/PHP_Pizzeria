<?php
declare(strict_types=1);
//city.php

namespace Entities;

class City
{
    private int $id;
    private string $zipcode;
    private string $city;
    private int $delivery_availability;

    public function __construct(int $id = 0, string $zipcode = '', string $city = '', int $delivery_availability = 0)
    {
        $this->id = $id;
        $this->zipcode = $zipcode;
        $this->city = $city;
        $this->delivery_availability = $delivery_availability;
    }

    // Add getter and setter methods for each property
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }
    public function getCity(): string
    {
        return $this->city;
    }
    public function getDeliveryAvailability(): int
    {
        return $this->delivery_availability;
    }
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setDeliveryAvailability(int $delivery_availability): void
    {
        $this->delivery_availability = $delivery_availability;
    }
}
