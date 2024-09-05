<?php
declare(strict_types=1);
//customer.php

namespace Entities;

class Customer
{
    private int $id;
    private string $name;
    private string $surname;
    private string $street;
    private int $number;
    private int $city_id;
    private string $email;
    private string $phone;
    private string $account_status;
    private string $password;
    private int $promo_status;

    public function __construct($id = 0, $name = '', $surname = '', $street = '', $number = 0, $city_id = 0, $email = '', $phone = '', $account_status = '', $password = '', $promo_status = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->street = $street;
        $this->number = $number;
        $this->city_id = $city_id;
        $this->email = $email;
        $this->phone = $phone;
        $this->account_status = $account_status;
        $this->password = $password;
        $this->promo_status = $promo_status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAccountStatus(): string
    {
        return $this->account_status;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPromoStatus(): int
    {
        return $this->promo_status;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getCityId(): int
    {
        return $this->city_id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setAccountStatus(string $account_status): void
    {
        $this->account_status = $account_status;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPromoStatus(int $promo_status): void
    {
        $this->promo_status = $promo_status;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function setCityId(int $city_id): void
    {
        $this->city_id = $city_id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'surname' => $this->getSurname(),
            'name' => $this->getName(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'city_id' => $this->getCityId(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'account_status' => $this->getAccountStatus(),
            'promo_status' => $this->getPromoStatus(),
        ];
    }

    public function getAddressString(): string
    {
        return $this->street . ' ' . $this->number;
    }
}
