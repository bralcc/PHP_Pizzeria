<?php
declare(strict_types= 1);
//citiesService.php

namespace Business;

use Data\CityDAO;

class CitiesService
{
    private CityDAO $cityDAO;

    public function __construct()
    {
        $this->cityDAO = new CityDAO();
    }

    public function getCities(): array
    {
        try {
            return $this->cityDAO->getAll();
        } catch (\Exception $e) {
            error_log("Error fetching cities: " . $e->getMessage());
            return [];
        }
    }

    public function getCity(int $id)
    {
        try {
            return $this->cityDAO->getById($id);
        } catch (\Exception $e) {
            error_log("Error fetching city: " . $e->getMessage());
            return null;
        }
    }

    public function getCityByName(string $name, string $zip)
    {
        try {
            return $this->cityDAO->getCityId($name, $zip);
        } catch (\Exception $e) {
            error_log("Error fetching city id: " . $e->getMessage());
            return null;
        }
    }
}
