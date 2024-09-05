<body>
    <main>
        <div class="container">
            <div class="basket">
                <div class="basket-order">
                    <h1>Your order:</h1>
                    <ul class="basket-items">
                        <?php
                        $subtotal = 0;
                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $orderline): ?>
                                <li class="basket-item">
                                    <form action="order.php" method="post">
                                        <?php $quantity = htmlspecialchars($orderline->getQuantity(), ENT_QUOTES, 'UTF-8');
                                        echo $quantity . 'x '; ?>
                                        <?php
                                        foreach ($products as $product) {
                                            if ($product->getId() == $orderline->getProductId()) {
                                                echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8') . ' - €' . htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8');
                                                $productPrice = $product->getPrice();
                                                $subtotal += $productPrice * $quantity;
                                                break;
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="product_id"
                                            value="<?php echo htmlspecialchars($orderline->getProductId(), ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="submit" name="remove" value="Remove" aria-label="Remove item from cart">
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Select a product</li>
                        <?php endif; ?>
                    </ul>
                    <div class="subtotal-container">
                        <span id="subtotal" class="subtotal-text">Subtotal:
                            €<?php echo number_format($subtotal, 2); ?></span>
                        <form action="order.php" method="post" class="order-form">
                            <input type="submit" name="order_confirm" value="Order" class="btn btn-primary">
                            <input type="submit" name="clear" value="Clear Cart" class="btn btn-secondary">
                        </form>
                    </div>
                </div>
            </div>
            <h1>Choose a pizza:</h1>
            <div class="products">
                <?php foreach ($products as $product):
                    if ($product->isAvailable() == 1) { ?>
                        <div class="product">
                            <div class="product-wrapper">
                                <form action="order.php" method="post">
                                    <h2><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <p><?php echo htmlspecialchars($product->getIngredients(), ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p>&euro; <?php echo htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8'); ?></p>
                                    <input type="hidden" name="product_id"
                                        value="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="submit" id="add" name="add" value="Add"
                                        aria-label="Add <?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?> to cart">
                                </form>
                            </div>
                        </div>
                    <?php }endforeach; ?>
            </div>
        </div>
    </main>
