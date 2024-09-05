<?php
declare(strict_types= 1);
//login.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Business\CustomerService;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $cService = new CustomerService();
    $customer = $cService->getByEmail($email);

    if ($customer !== null && password_verify($password, $customer->getPassword())) {

        session_regenerate_id(true);
        $_SESSION['customer'] = $customer;
        $_SESSION['messages'] = 'You have been logged in';

        if (isset($_SESSION['return_path'])) {
            if ($_SESSION['return_path'] === 'order.php' && isset($_SESSION['order'])) {
                $_SESSION['order']->setCustomerId($_SESSION['customer']->getId());
            }
            $returnPath = $_SESSION['return_path'];
            unset($_SESSION['return_path']); // Clear the return path from session
            session_write_close();
            header('Location: ' . $returnPath);
            exit;
        } else {
            // Default redirection if no specific return path is set
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['errors'][] = 'Invalid email or password';
    }
}


require_once 'app/Presentation/header_public.php';
displaySessionErrors();
displaySessionMessages();
require_once 'app/Presentation/login_view.php';
require_once 'app/Presentation/footer.php';

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

function displaySessionMessages()
{
    if (isset($_SESSION['messages'])) {
        echo '<div class="session-messages"><ul>';
        foreach ($_SESSION['messages'] as $message) {
            echo '<li class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul></div>';
        unset($_SESSION['messages']);
    }
}
