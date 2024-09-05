<?php
declare(strict_types=1);

namespace Business;

use Data\OrderDAO;
use Exception;

class OrderService
{
    /**
     * Creates an order and returns the order id.
     *
     * @param object $data Data object containing order details.
     * @return mixed Returns id on success, or false on failure.
     */
    public function createOrder($data)
    {
        $orderDAO = new OrderDAO();
        $orderData = $data->toArray(); //Assuming this method exists in the Order class

        try {
            return $orderDAO->insert($orderData);
        } catch (Exception $e) {
            echo "Error inserting order: " . $e->getMessage();
        }
    }

    public function addOrderLine($data)
{
    $orderDAO = new OrderDAO();
    $orderLineData = $data->toArray(); //Assuming this method exists in the OrderLine class
    try {
        return $orderDAO->insertOrderLine($orderLineData);
    } catch (Exception $e) {
        echo "Error inserting orderline: " . $e->getMessage();
    }
}
    public function updateOrder($order)
    {
        $orderDAO = new OrderDAO();
        try {
            $orderDAO->setStatus($order);
        } catch (Exception $e) {
            echo "Error updating status of order: " . $e->getMessage();
        }
    }
}
