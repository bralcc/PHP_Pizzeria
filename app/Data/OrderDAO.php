<?php
declare(strict_types=1);

namespace Data;

use Data\DBConfig;
use PDO;
use PDOException;
use Exceptions\DatabaseErrorException;
use Entities\Order;

class OrderDAO
{
    public function getAll(): array
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Prepare SQL
            $sql = "SELECT * FROM orders";
            $stmt = $dbh->prepare($sql);
            // Execute SQL
            $stmt->execute();
            // Fetch all results
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Kill db
            $dbh = null;

            $list = [];
            foreach ($result as $row) {
                $order = new Order();
                $order->setId($row["id"]);
                $order->setCustomerId($row["customer_id"]);
                $order->setCreatedAt($row["date"]);
                $order->setTotalPrice($row["total"]);
                $order->setStatus($row["status"]);
                $order->setDeliveryInfo($result["delivery_info"]);
                $list[] = $row;
            }
            return $list;
        } catch (PDOException $e) {
            error_log("Error fetching orders: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching orders: ' . $e->getMessage());
        }
    }

    public function getById($id): Order
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM orders WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            // Bind values and execute
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            // Fetch result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Kill db
            $dbh = null;

            $order = new Order();
            $order->setId($result["id"]);
            $order->setCustomerId($result["customer_id"]);
            $order->setCreatedAt($result["date"]);
            $order->setTotalPrice($result["total"]);
            $order->setStatus($result["status"]);
            $order->setDeliveryInfo($result["delivery_info"]);
            return $order;
        } catch (PDOException $e) {
            error_log("Error fetching order: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching order: ' . $e->getMessage());
        }
    }

    public function insert(array $data): string
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Prepare SQL
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));
            $sql = "INSERT INTO orders ($columns) VALUES ($placeholders)";
            $stmt = $dbh->prepare($sql);

            // Bind values and execute
            $stmt->execute(array_values($data));
            $lastInsertId = $dbh->lastInsertId();

            if (!$lastInsertId) {
                throw new DatabaseErrorException("Something went wrong while adding the order");
            }

            return $lastInsertId;

        } catch (PDOException $e) {
            error_log("Error creating order: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating order: ' . $e->getMessage());
        }
    }

    public function insertOrderLine(array $data): void
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Prepare SQL
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));
            $sql = "INSERT INTO orderlines ($columns) VALUES ($placeholders)";
            $stmt = $dbh->prepare($sql);
            // Bind values and execute
            $result = $stmt->execute(array_values($data));
            // Kill db
            $dbh = null;
            if ($result) {
                echo "Orderline added successfully";
            } else {
                echo "Something went wrong while adding the orderlines";
            }
        } catch (PDOException $e) {
            error_log("Error creating orderlines: " . $e->getMessage());
            throw new DatabaseErrorException('Error creating orderlines: ' . $e->getMessage());
        }
    }

    public function setStatus(Order $order): void
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Prepare SQL
            $sql = "UPDATE orders SET customer_id = :customer_id, created_at = :date, total = :total, status = :status, delivery_info = :delivery_info WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            // Bind values and execute
            $id = $order->getId();
            $customer_id = $order->getCustomerId();
            $date = $order->getCreatedAt();
            $total = $order->getTotalPrice();
            $status = $order->getStatus();
            $delivery_info = $order->getDeliveryInfo();

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
            $stmt->bindParam(":date", $date, PDO::PARAM_STR);
            $stmt->bindParam(":total", $total, PDO::PARAM_STR);
            $stmt->bindParam(":status", $status, PDO::PARAM_STR);
            $stmt->bindParam(":delivery_info", $delivery_info, PDO::PARAM_STR);
            $result = $stmt->execute();
            // Kill db
            $dbh = null;
            if ($result) {
                echo "Order updated successfully";
            } else {
                echo "Something went wrong while updating the order";
            }
        } catch (PDOException $e) {
            error_log("Error updating order: " . $e->getMessage());
            throw new DatabaseErrorException('Error updating order: ' . $e->getMessage());
        }
    }
}
