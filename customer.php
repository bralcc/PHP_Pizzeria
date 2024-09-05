<?php
declare(strict_types= 1);
//customer.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Business\CustomerService;
use Business\CitiesService;

session_start();

// Check if customer exists
if (!isset($_SESSION['customer'])) {
    echo "User not found.";
    header('Location: index.php');
    exit;
}

//Determine controller and action
$action = $_GET['action'] ?? 'profile';

switch ($action) {
    case 'profile':
        handleProfile();
        break;
    case 'edit':
        handleEdit();
        break;
    case 'update':
        handleUpdate();
        break;
    default:
        handleProfile();
        break;
}

function handleProfile()
{
    $customer = $_SESSION['customer'];
    handleHeader();
    displaySessionMessages();
    $citiesService = new CitiesService();
    $city = $citiesService->getCity($customer->getCityId());
    require_once 'app/Presentation/customer_profile.php';
    handleFooter();
}

function handleEdit()
{
    $customer = $_SESSION['customer'];
    handleHeader();
    displaySessionMessages();
    displaySessionErrors();
    $citiesService = new CitiesService();
    $cities = $citiesService->getCities();
    require_once 'app/Presentation/customer_edit.php';
    handleFooter();
}

function handleUpdate()
{
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    $_SESSION['customer'] = ''; // Clear the session customer object
    $customerService = new CustomerService();
    $updatedCustomer = $customerService->updateCustomer();
    $_SESSION['customer'] = $updatedCustomer; // Update the session with the new customer object
    $_SESSION['message'] = 'Your profile has been updated';
    header('Location: customer.php');
    exit;
}

function handleHeader()
{
    if (isset($_SESSION['customer'])) {
        $customer = $_SESSION['customer'];
        require_once 'app/Presentation/header_private.php';
    } else {
        require_once 'app/Presentation/header_public.php';
    }
}

function handleFooter()
{
    require_once 'app/Presentation/footer.php';
}

function displaySessionMessages()
{
    if (isset($_SESSION['message'])) {
        echo '<div class="session-message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']); // Clear the message after displaying it
    }
}

function displaySessionErrors()
{
    if (isset($_SESSION['errors'])) {
        echo '<div class="session-errors">';
        foreach ($_SESSION['errors'] as $error) {
            echo '<div class="session-error">' . $error . '</div>';
        }
        echo '</div>';
        unset($_SESSION['errors']); // Clear the errors after displaying them
    }
}
