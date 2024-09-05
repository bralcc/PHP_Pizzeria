<?php
declare(strict_types=1);
//product.php

namespace Entities;

class Product
{
    private int $id;
    private string $name;
    private string $ingredients;
    private float $price;
    private int $available;
    private float $promo_modifier;
    private int $seasonal;

    public function __construct(int $id = 0, string $name = '', string $ingredients = '', float $price = 0.0, int $available = 0, float $promo_modifier = 0.0, int $seasonal = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->price = $price;
        $this->available = $available;
        $this->promo_modifier = $promo_modifier;
        $this->seasonal = $seasonal;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function isAvailable(): int
    {
        return $this->available;
    }

    public function setAvailable(int $available): void
    {
        $this->available = $available;
    }

    public function getPromoModifier(): float
    {
        return $this->promo_modifier;
    }

    public function setPromoModifier(float $promo_modifier): void
    {
        $this->promo_modifier = $promo_modifier;
    }

    public function isSeasonal(): int
    {
        return $this->seasonal;
    }

    public function setSeasonal(int $seasonal): void
    {
        $this->seasonal = $seasonal;
    }
}
