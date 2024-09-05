<?php
declare(strict_types= 1);
//account.check.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

session_start();

if (!isset ($_SESSION['customer'])) {
    require_once 'app/Presentation/header_public.php';
    require_once 'app/Presentation/account_check_view.php';
    require_once 'app/Presentation/footer.php';
} else {
    header('Location: order.php');
    exit;
}
