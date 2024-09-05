<body>
    <main>
    <div class="container">
        <div class="edit-profile-wrapper">
            <h1>Edit Customer Profile</h1>
            <form action="customer.php?action=update" method="POST">
                <input type="hidden" name="id" value="<?php echo $customer->getId(); ?>">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $customer->getName(); ?>" required>
                </div>
                <div>
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" value="<?php echo $customer->getSurname(); ?>"
                        required>
                </div>
                <div>
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" value="<?php echo $customer->getStreet(); ?>" required>
                </div>
                <div>
                    <label for="number">Number:</label>
                    <input type="text" id="number" name="number" value="<?php echo $customer->getNumber(); ?>" required>
                </div>
                <div>
                    <label for="city">City:
                    <select name="city_id" id="city">
                        <?php foreach ($cities as $city) : ?>
                        <option value="<?php echo $city->getId(); ?>"
                            <?php echo $city->getId() == $customer->getCityId() ? 'selected' : ''; ?>>
                            <?php echo $city->getZipcode() . ' ' . $city->getCity() . ' - ' .
                            ($city->getDeliveryAvailability() ? 'Delivery available' : 'Delivery not available') ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    </label>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $customer->getEmail(); ?>" required>
                </div>
                <div>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $customer->getPhone() ?>" required>
                </div>
                <div>
                    <label for="account_status">Account Status:</label>
                    <input type="text" id="account_status" name="account_status"
                        value="<?php echo $customer->getAccountStatus(); ?>" disabled required>
                </div>
                <div>
                    <label for="promo_status">Promo available:</label>
                    <input type="text" id="promo_status" name="promo_status"
                        value="<?php echo $customer->getPromoStatus(); ?>" disabled required>
                </div>
                <button type="submit" name="customer_edited">Save Changes</button>
            </form>
        </div>
    </div>
    </main>
