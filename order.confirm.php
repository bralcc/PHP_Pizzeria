<?php
declare(strict_types=1);
//order.confirm.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Business\CitiesService;
use Business\ProductService;
use Business\OrderService;

session_start();

unset($_SESSION['success']);

// Check if customer is logged in
if (!isset($_SESSION['customer']) || $_SESSION['customer'] == '' || empty($_SESSION['customer'])) {
    unset($_SESSION['order_confirm']);
    $_SESSION['errors'][] = 'You must be logged in to place an order';
    header('Location: login.php');
    exit;
    
} else {
    // Check if customer has an address
    $customer = $_SESSION['customer'];
    $cityId = $customer->getCityId();
    if ($cityId) {
        // Check if delivery is available
        $cityService = new CitiesService();
        $city = $cityService->getCity($cityId);
        if ($city->getDeliveryAvailability() === 0) {
            $_SESSION['errors'][] = 'Delivery is not possible to your address. Please change your address';
            header('Location: customer.php?action=edit');
            exit;
        }
    } else {
        $_SESSION['errors'][] = 'You need to add an address to your account before you can place an order';
        header('Location: customer.php?action=edit');
        exit;
    }
}

// Check if the order has not been processed yet
if (!isset($_SESSION['order_processed'])) {
    // Check if the cart is not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        //Fetch all products for calculating the total price
        $productService = new ProductService();
        $products = $productService->getAll();

        //Get order from session
        $order = $_SESSION['order'];
        $order->setTotalPrice((float) 0);

        //Check if customer is eligible for discount and add flag
        $discountFlag = false;
        if ($customer->getPromoStatus() == 1) {
            // //Get current season
            // $seasonService = new SeasonService();
            // $currentSeason = $seasonService->getCurrentSeason();

            // //Get all seasonal products
            // $productService = new ProductService();
            // $seasonalProducts = $productService->getSeasonalProducts();

            // //Check if seasonal products are in season
            // $seasonalProductsIds = $seasonService->checkSeasonalProducts($seasonalProducts, $currentSeason);

            $discountFlag = true;
        }

        // Index products for faster lookup
        $indexedProducts = [];
        foreach ($products as $product) {
            $indexedProducts[$product->getId()] = $product;
        }

        foreach ($_SESSION['cart'] as $orderline) {
            $productId = $orderline->getProductId();
            if (isset($indexedProducts[$productId])) {
                $product = $indexedProducts[$productId];
                $productPrice = $product->getPrice();
                if ($product->isSeasonal() && $discountFlag) {
                    $productPrice *= $product->getPromoModifier();
                }
                $order->setTotalPrice($order->getTotalPrice() + ($productPrice * $orderline->getQuantity()));
            }
        }

        //Send order to database
        $order->setStatus('Not paid');
        $orderService = new OrderService();
        $orderId = $orderService->createOrder($order);
        $order->setId(intval($orderId));

        // Check if order is sent and returned the id succesfully
        if (!$orderId) {
            $_SESSION['errors'][] = 'Er is een fout opgetreden bij het plaatsen van uw bestelling';
            header('Location: order.php');
            exit;

        } else {
            //Set order id to orderlines and add to database
            foreach ($_SESSION['cart'] as $orderline) {
                $orderline->setOrderId(intval($orderId));
                $orderService->addOrderLine($orderline);
            }
        }

        //Set the order to the session
        $_SESSION['order'] = $order;

        // After processing the order, set a flag in the session
        $_SESSION['order_processed'] = true;

        // Redirect to the same page to prevent reprocessing on refresh
        header('Location: order.confirm.php');
        exit;

    } else {
        //If the cart is empty, redirect to the order page
        $_SESSION['errors'][] = 'Select a product to order';
        header('Location: order.php');
        exit;
    }

}

// Check if the order has been paid
if (isset($_POST['order_paid']) && $_POST['order_paid'] === 'Confirm and pay') {
    //Set order to paid
    $order = $_SESSION['order'];
    $order->setStatus('Completed');
    $order->setDeliveryInfo(filter_var($_POST['delivery_info'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $orderService = new OrderService();
    $orderService->updateOrder($order);
    // Unset all unnecessary session variables
    unset($_SESSION['order_confirm']);
    unset($_SESSION['order_processed']);
    unset($_SESSION['cart']);
    unset($_SESSION['order']);
    unset($_SESSION['errors']);
    unset($_SESSION['success']);

    // Set success message
    $_SESSION['messages'] = 'Your order is on its way!';
    // Head to completed page
    header('Location: index.php');
    exit;
}

// If the page is refreshed after processing the order, this part will be executed
require_once 'app/Presentation/header_private.php';

//Get variables for displaying the order
$order = $_SESSION['order'];
$productService = new ProductService();
$products = $productService->getAll();

require_once 'app/Presentation/order_confirm_view.php';
require_once 'app/Presentation/footer.php';
