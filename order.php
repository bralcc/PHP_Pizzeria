<?php
declare(strict_types=1);
//order.php
require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Business\ProductService;
use Entities\Order;
use Entities\Orderline;

session_start();

//initialize cart of the customer
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

//initialize order
if (!isset($_SESSION['order'])) {
    $order = new Order();
    if (isset($_SESSION['customer'])) {
        $order->setCustomerId(intval($_SESSION['customer']->getId()));
    }
    $order->setCreatedAt(date('Y-m-d H:i:s'));
    $order->setTotalPrice(0);
    $_SESSION['order'] = $order;
}

if (isset($_SESSION['order']) && (!isset($_SESSION['customer']) || $_SESSION['customer'] === '' || empty($_SESSION['customer']))) {
    $order = $_SESSION['order'];
    $order->setCustomerId(0);
    $_SESSION['order'] = $order;
}

// After handling form submissions, such as adding/removing products or clearing the cart
if (isset($_POST['add']) || isset($_POST['remove']) || isset($_POST['clear'])) {

    //if the customer has added a product to the cart
    if (isset($_POST['add']) && isset($_SESSION['cart'])) {
        $productFound = false;
        foreach ($_SESSION['cart'] as &$orderline) {
            if ($orderline->getProductId() === intval($_POST['product_id'])) {
                $orderline->setQuantity((int) $orderline->getQuantity() + 1);
                $productFound = true;
                break;
            }
        }
        unset($orderline); //break the reference with the last element of the loop

        //if the product is not in the cart, add it
        if (!$productFound) {
            $orderline = new Orderline();
            $orderline->setProductId(intval($_POST['product_id']));
            $orderline->setQuantity(1);
            $_SESSION['cart'][] = $orderline;
            unset($orderline);
        }
    }

    //if the customer has removed a product from the cart
    if (isset($_POST['remove']) && isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $orderline) {
            if ($orderline->getProductId() === intval($_POST['product_id'])) {
                unset($_SESSION['cart'][$key]);

                // Re-index the array to prevent potential issues with missing keys !IMPORTANT!
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }

    //if the customer has cleared the cart
    if (isset($_POST['clear']) && isset($_SESSION['cart'])) {
        //clear the cart
        $_SESSION['cart'] = [];
    }
    header('Location: order.php');
    exit; // Ensure no further code is executed before the redirect
}


//if the customer has placed an order
if (isset($_POST['order_confirm'])) {
    // check if the cart is empty
    if (empty($_SESSION['cart'])) {
        $_SESSION['errors'][] = 'Select a product';
    } else {
        // Check if the customer is already in the session
        if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
            // Redirect to account check page
            unset($_SESSION['order_confirm']);
            header('Location: account_check.php');
            $_SESSION['return_path'] = 'order.php';
            exit;
        } else {
            // check if customer id is set in the order
            if (!$_SESSION['order']->getCustomerId()) {
                $_SESSION['order']->setCustomerId(intval($_SESSION['customer']->getId()));
            }
            // Customer exists, proceed to order confirmation page
            $_SESSION['order_confirm'] = true;
            header('Location: order.confirm.php');
            exit;
        }
    }
}

//PRESENTATION LOGIC
function displaySessionErrors()
{
    if (isset($_SESSION['errors'])) {
        echo '<div class="session-errors"><ul>';
        foreach ($_SESSION['errors'] as $error) {
            echo '<li class="error">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul></div>';
        unset($_SESSION['errors']);
    }
}

//fetch the customer from the session to print on page
$customer = $_SESSION['customer'] ?? null;

//fetch all products to print on page
$pService = new ProductService();
$products = $pService->getAll();

if (isset($_SESSION['customer']) && $_SESSION['customer'] !== '' && !empty($_SESSION['customer'])) {
    require_once 'app/Presentation/header_private.php';
} else {
    require_once 'app/Presentation/header_public.php';
}
displaySessionErrors();
require_once 'app/Presentation/order_view.php';
require_once 'app/Presentation/footer.php';
