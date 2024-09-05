<?php
declare(strict_types=1);

namespace Data;

use Data\DBConfig;
use PDO;
use PDOException;
use Exceptions\DatabaseErrorException;
use Entities\Product;
use Entities\SeasonalProduct;

class ProductDAO
{
    public function fetchAll(): array
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch all results
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            $products = [];
            foreach ($resultSet as $row) {
                $product = new Product(
                    $row['id'],
                    $row['name'],
                    $row['ingredients'],
                    $row['price'],
                    $row['available'],
                    $row['promo_modifier'],
                    $row['seasonal']
                );
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching products: ' . $e->getMessage());
        }
    }

    public function fetchSeasonalProducts(): array
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM seasonsproducts";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch all results
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            $products = [];
            foreach ($resultSet as $row) {
                $seasonalProduct = new SeasonalProduct(
                    $row['season_id'],
                    $row['product_id']
                );
                $products[] = $seasonalProduct;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("Error fetching seasonal products: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching seasonal products: ' . $e->getMessage());
        }
    }

    public function getById($id): Product
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products WHERE id = :id";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            return new Product(
                $row['id'],
                $row['name'],
                $row['ingredients'],
                $row['price'],
                $row['available'],
                $row['promo_modifier'],
                $row['seasonal']
            );

        } catch (PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching product: ' . $e->getMessage());
        }
    }

    public function getByName($name)
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products WHERE name = :name";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['name' => $name]);

            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            return new Product(
                $row['id'],
                $row['name'],
                $row['ingredients'],
                $row['price'],
                $row['available'],
                $row['promo_modifier'],
                $row['seasonal']
            );
        } catch (PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching product: ' . $e->getMessage());
        }
    }

    public function checkAvailability($id): bool
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT available FROM products WHERE id = :id";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Fetch the result
            $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            return true;
        } catch (PDOException $e) {
            error_log("Error fetching product availability: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching product availability: ' . $e->getMessage());
        }
    }
}
