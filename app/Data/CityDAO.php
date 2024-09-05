<?php
declare(strict_types=1);
//citiesDAO.php

namespace Data;

use Data\DBConfig;
use PDO;
use PDOException;
use Exceptions\DatabaseErrorException;
use Entities\City;

class CityDAO
{
    public function getAll(): array
    {
        $list = array();
        $index = 1;

        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM cities";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch the results
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            foreach ($resultSet as $row) {
                $city = new City;
                $city->setId($row['ID']);
                $city->setZipcode($row['Zipcode']);
                $city->setCity($row['Name']);
                $city->setDeliveryAvailability($row['delivery_availability']);
                $list[$index++] = $city;
            }

            return $list;

        } catch (PDOException $e) {
            error_log("Error fetching cities map: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating cities map: ' . $e->getMessage());
        }
    }
    public function getById($id)
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT zipcode, name, delivery_availability FROM cities WHERE id = :id";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the results
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $dbh = null;

            //Construct city class
            $city = new City();
            $city->setId($id);
            $city->setZipcode($result['zipcode']);
            $city->setCity($result['name']);
            $city->setDeliveryAvailability($result['delivery_availability']);
            return $city;

        } catch (PDOException $e) {
            error_log("Error fetching city by id: " . $e->getMessage());
            throw new DatabaseErrorException('Error getting city by id: ' . $e->getMessage());
        }
    }

    public function getCityId($zipcode, $city)
    {
        try {
            $sql = "SELECT ID FROM cities WHERE Zipcode = :zipcode AND Name = :city";

            //Open database connection because it gives null for some f***ing reason
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the results
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            return intval($result['ID']);

        } catch (PDOException $e) {
            error_log("Error fetching city id: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating medication: ' . $e->getMessage());
        }
    }

    public function createCity($zipcode, $city)
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO cities (Zipcode, Name) VALUES (:zipcode, :city)";
            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->execute();
            // Get the ID of the newly created city
            return $dbh->lastInsertId();

        } catch (PDOException $e) {
            error_log("Error creating city: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating city: ' . $e->getMessage());
        } finally {
            // Close dbh
            $dbh = null;
        }
    }
}
