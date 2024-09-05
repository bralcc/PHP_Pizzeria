<?php
declare(strict_types=1);
// customerDAO.php

namespace Data;

use Entities\Customer;
use Data\DBConfig;
use PDO;
use PDOException;
use Exceptions\DatabaseErrorException;

class CustomerDAO
{
    public function create(Customer $customer): Customer
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO customers (name, surname, street, number, city_id, email, phone, account_status, password, promo_status) VALUES (:name, :surname, :street, :number, :city_id, :email, :phone, :account_status, :password, :promo_status)";

            // Prepare and execute the SQL query

            $stmt = $dbh->prepare($sql);

            $stmt->execute([
                'name' => $customer->getName(),
                'surname' => $customer->getSurname(),
                'street' => $customer->getStreet(),
                'number' => intval($customer->getNumber()),
                'city_id' => intval($customer->getCityId()),
                'email' => $customer->getEmail(),
                'phone' => $customer->getPhone(),
                'account_status' => $customer->getAccountStatus(),
                'password' => $customer->getPassword(),
                'promo_status' => $customer->getPromoStatus()
            ]);

            $customerId = intval($dbh->lastInsertId());
            $customer->setId($customerId);

            $dbh = null;

            return $customer;

        } catch (PDOException $e) {
            error_log("Error creating customer: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating customer: ' . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        $list = array();
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM customers";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch the results
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            foreach ($resultSet as $row) {
                //Construct customer class
                $customer = new Customer(
                    $row["id"],
                    $row["name"],
                    $row['surname'],
                    $row['street'],
                    $row['number'],
                    $row['city_id'],
                    $row["email"],
                    $row["phone"],
                    $row["account_status"],
                    $row["password"],
                    $row["promo_status"]
                );
                array_push($list, $customer);
            }
            return $list;
        } catch (PDOException $e) {
            error_log("Error fetching customers: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching customers: ' . $e->getMessage());
        }
    }

    public function getByEmail($email)
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM customers WHERE email = :email";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['email' => $email]);

            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            //Construct customer class
            return new Customer(
                $row["id"],
                $row["name"],
                $row['surname'],
                $row['street'],
                $row['number'],
                $row['city_id'],
                $row["email"],
                $row["phone"],
                $row["account_status"],
                $row["password"],
                $row["promo_status"]
            );
        } catch (PDOException $e) {
            error_log("Error fetching customer: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching customer: ' . $e->getMessage());
        }

    }

    public function update($data, $id): Customer
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Generate the SET part of the SQL statement dynamically
            $columns = array_keys($data);
            $placeholders = array_map(fn($column) => "$column = ?", $columns);
            $setClause = implode(', ', $placeholders);

            // Construct the SQL statement
            $sql = "UPDATE customers SET $setClause WHERE id = ?";
            $stmt = $dbh->prepare($sql);

            // Bind values and execute
            $values = array_values($data);
            $values[] = $id; // Add the ID to the end of the values array for the WHERE clause
            $stmt->execute($values);

            // Construct the SQL statement for retrieving the updated customer
            $sql = "SELECT * FROM customers WHERE id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$id]);
            $customerData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            if ($customerData) {
                // Assuming you have a Customer class that can be populated like this
                $customer = new Customer();
                $customer->setId($customerData['id']);
                $customer->setName($customerData['name']);
                $customer->setSurname($customerData['surname']);
                $customer->setEmail($customerData['email']);
                $customer->setPhone($customerData['phone']);
                $customer->setAccountStatus($customerData['account_status']);
                $customer->setPassword($customerData['password']);
                $customer->setPromoStatus($customerData['promo_status']);
                $customer->setStreet($customerData['street']);
                $customer->setNumber($customerData['number']);
                $customer->setCityId($customerData['city_id']);
                return $customer; // Return the populated Customer object
            } else {
                throw new \Exception("Customer not found with ID: $id");
            }

        } catch (PDOException $e) {
            error_log("Error updating customer: " . $e->getMessage());
            throw new DatabaseErrorException('Error updating customer: ' . $e->getMessage());
        }
    }
}
