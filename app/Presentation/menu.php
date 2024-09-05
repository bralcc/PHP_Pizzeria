<body>
    <div class="container">
    <h1>Our pizzas:</h1>
        <div class="menu-container">
            <?php foreach ($products as $product): ?>
                <div class="menu-item">
                    <div class="item-image">
                        <img src="app/presentation/images/defaultpizza.png" alt="pizza" width="100">
                    </div>
                    <div class="item-info">
                        <h2><?php echo htmlspecialchars($product->getName()); ?></h2>
                        <p><?php echo htmlspecialchars($product->getIngredients()); ?></p>
                        <span>Price: € <?php echo htmlspecialchars($product->getPrice()); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
