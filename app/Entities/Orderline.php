<?php
declare(strict_types=1);
//orderline.php

namespace Entities;

class Orderline {
    private $order_id;
    private $product_id;
    private $quantity;

    public function __construct(?int $order_id = null, ?int $product_id = null, ?int $quantity = 0)
    {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
