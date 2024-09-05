<?php
declare(strict_types=1);
//index.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Business\ProductService;

session_start();

// Unset customer session if it is empty
if (isset ($_SESSION['customer']) && ($_SESSION['customer'] == '' || empty($_SESSION['customer']))) {
    unset($_SESSION['customer']);
    unset($_SESSION['order_confirm']);
    unset($_SESSION['order_processed']);
}

// Include the correct header based on the session
if (isset($_SESSION['customer']) && $_SESSION['customer'] !== '' && !empty($_SESSION['customer'])) {
    require_once 'app/Presentation/header_private.php';
} else {
    require_once 'app/Presentation/header_public.php';
}

// Display session messages
if (isset($_SESSION['messages'])) {
    echo '<div class="session-messages"><ul>';
    foreach ($_SESSION['messages'] as $message) {
        echo '<li class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo '</ul></div>';
    unset($_SESSION['messages']);
}

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    echo '<div class="session-message">You have been logged out</div>';
}

// Include homepage and footer
if (isset($_GET['action']) && $_GET['action'] === 'menu') {
    $pService = new ProductService();
    $products = $pService->getAll();
    require_once 'app/Presentation/menu.php';
} else {
    require_once 'app/Presentation/homepage.php';
}

require_once 'app/Presentation/footer.php';
