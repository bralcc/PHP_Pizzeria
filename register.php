<?php
declare(strict_types=1);
//register.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Business\CitiesService;
use Entities\Customer;
use Business\CustomerService;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sanitizedData = [
        'surname' => filter_var(trim($_POST['surname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'name' => filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'street' => filter_var(trim($_POST['street']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'number' => filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'city_id' => filter_var($_POST['city_id'], FILTER_SANITIZE_NUMBER_INT),
        'phone' => filter_var(trim($_POST['phone']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
        'password' => $_POST['password'] // Password will be hashed, no need for sanitization
    ];

    $passwordHash = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
    $customer = new Customer(
        0,
        $sanitizedData['name'],
        $sanitizedData['surname'],
        $sanitizedData['street'],
        intval($sanitizedData['number']),
        intval($sanitizedData['city_id']),
        $sanitizedData['email'],
        $sanitizedData['phone'],
        'active',
        $passwordHash,
    );
    $cService = new CustomerService();
    $newCustomer = $cService->newCustomer($customer);

    if (!$newCustomer) {
        $_SESSION['errors'][] = 'Error creating customer';
        header('Location: register.php');
        exit;
    } else {
        if (isset($_SESSION['return_path'])) {
            $_SESSION['customer'] = $newCustomer;
            $returnPath = $_SESSION['return_path'];
            unset($_SESSION['return_path']); // Clear the return path from session
            header('Location: ' . $returnPath);
            exit;
        } else {
        $_SESSION['messages'][] = 'Customer created successfully';
        header('Location: login.php');
        exit;
        }
    }
}

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

require_once 'app/Presentation/header_public.php';
$cService = new CitiesService();
$cities = $cService->getCities();
displaySessionErrors();
require_once 'app/Presentation/register_view.php';
require_once 'app/Presentation/footer.php';
