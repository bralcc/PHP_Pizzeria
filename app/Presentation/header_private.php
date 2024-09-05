<?php
$customer = $_SESSION['customer'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <header>
        <h1>Pizzeria Mary</h1>
        <img src="app/presentation/images/pizza.png" alt="logo" width="80px" height="80">
        <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="order.php">Order</a></li>
                <li><a href="customer.php?action=profile">Profile</a></li>
            </ul>
        </nav>
    </header>
