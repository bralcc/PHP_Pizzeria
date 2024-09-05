<?php
declare(strict_types= 1);
//seasonalProduct.php

namespace Entities;

class SeasonalProduct {
    private $season_id;
    private $product_id;

    public function __construct(int $season_id = 0, int $product_id = 0) {
        $this->season_id = $season_id;
        $this->product_id = $product_id;
    }
    public function getSeasonId(): int {
        return $this->season_id;
    }

    public function setSeasonId(int $season_id): void {
        $this->season_id = $season_id;
    }

    public function getProductId(): int {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void {
        $this->product_id = $product_id;
    }
}
