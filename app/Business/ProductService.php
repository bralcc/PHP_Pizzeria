<?php
declare(strict_types= 1);
//productService.php

namespace Business;

use Data\ProductDAO;

class ProductService {
    public function getAll() : array {
        $dao = new ProductDAO();
        return $dao->fetchAll();
    }

    public function getSeasonalProducts() : array {
        $dao = new ProductDAO();
        return $dao->fetchSeasonalProducts();
    }

    public function checkAvailability(int $id) : bool {
        $dao = new ProductDAO();
        return $dao->checkAvailability($id);
    }
}
