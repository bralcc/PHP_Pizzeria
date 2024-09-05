<body>
    <main>
        <div class="container">
            <div class="register-wrapper">
                <h1>Register</h1>
                <form action="register.php" method="POST">
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" required><br>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>

                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" required><br>

                    <label for="number">Number:</label>
                    <input type="text" id="number" name="number" required><br>

                    <label for="city">City:
                        <select name="city_id" id="city">
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo $city->getId(); ?>">
                                    <?php echo $city->getZipcode() . ' ' . $city->getCity() . ' - ' .
                                        ($city->getDeliveryAvailability() ? 'Delivery available' : 'Delivery not available') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br>

                    <label for="repeatpassword">Repeat Password:</label>
                    <input type="password" id="repeatpassword" name="repeatpassword" required><br>
                    <button type="submit" name="register" value="register">Submit</button>
                </form>
            </div>
        </div>
    </main>
