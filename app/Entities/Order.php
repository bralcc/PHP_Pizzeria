<?php
declare(strict_types=1);

namespace Entities;

date_default_timezone_set('Europe/Brussels');

class Order
{
    private int $id;
    private int $customer_id;
    private float $total;
    private string $status;
    private string $created_at;
    private string $delivery_info;

    public function __construct(int $id = 0, int $customer_id = 0, float $total = 0.0, string $status = 'pending', string $created_at = '', string $delivery_info = '')
    {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->total = $total;
        $this->status = $status;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
        $this->delivery_info = $delivery_info;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    public function getTotalPrice(): float
    {
        return $this->total;
    }

    public function getDeliveryInfo(): string
    {
        return $this->delivery_info;
    }
    public function setTotalPrice(float $total): void
    {
        $this->total = $total;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
    public function setDeliveryInfo(string $delivery_info): void
    {
        $this->delivery_info = $delivery_info;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
