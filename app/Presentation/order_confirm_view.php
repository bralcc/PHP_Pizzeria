<body>
    <main>
        <div class="container">
            <div class="order-confirm">
                <h1>Order summary</h1>
                <p>Thank you for your order! Below are the details of your order.</p>

                <div class="order-summary">
                    <h2><strong>Order No: <?php echo $order->getId(); ?> </strong></h2>
                    <p><strong>Order Status:</strong> <?php echo $order->getStatus(); ?></p>
                    <p><strong>Order Date:</strong> <?php echo $order->getCreatedAt(); ?></p>
                    <p><strong>Customer Name:</strong>
                        <?php echo $customer->getName() . ' ' . $customer->getSurname(); ?>
                    </p>
                    <p><strong>Shipping Address:</strong>
                        <?php echo $customer->getAddressString() . ', ' . $city->getZipcode() . ' ' . $city->getCity() ?>
                    </p>

                    <h3>Order Items</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td><?php
                                    foreach ($products as $product) {
                                        if ($product->getId() === $item->getProductId()) {
                                            echo $product->getName();
                                            break;
                                        }
                                    }
                                    ?></td>
                                    <td><?php echo $item->getQuantity(); ?></td>
                                    <td>€ <?php
                                    $productPrice = 0; // Initialize $productPrice
                                    foreach ($products as $product) {
                                        if ($product->getId() === $item->getProductId()) {
                                            $productPrice = $product->getPrice();
                                            break; // Exit the loop once the price is found
                                        }
                                    }
                                    echo $productPrice; // Echo the price outside the loop
                                    ?></td>
                                    <td>€ <?php echo $productPrice * $item->getQuantity(); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p><strong>Discount applied: <?php if ($customer->getPromoStatus() === 'active') {
                        echo 'Yes';
                    } else {
                        echo 'No';
                    } ?> </strong></p>
                    <p><strong>Order Total:</strong> € <?php echo number_format($order->getTotalPrice(), 2); ?></p>
                </div>
                <div class="delivery-info">
                    <form action="order.confirm.php" method="post">
                        <label for="delivery_info">Extra info for delivery:</label>
                        <textarea id="delivery_info" name="delivery_info" rows="4" cols="50"
                            placeholder="Don't ring doorbell for dog."></textarea>
                        <br>
                        <input type="submit" name="order_paid" value="Confirm and pay">
                    </form>
                </div>
            </div>
        </div>
    </main>
