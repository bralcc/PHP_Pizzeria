<body>
    <main>
        <div class="container">
            <div class="profile-wrapper">
                <h1>Customer Profile</h1>
                <div class="customer-info">
                    <h2>Personal Information</h2>
                    <p><strong>Name:</strong>
                        <?php echo htmlspecialchars($customer->getName() . ' ' . $customer->getSurname()); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($customer->getEmail()); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer->getPhone()); ?></p>
                </div>
                <div class="account-info">
                    <h2>Account Details</h2>
                    <p><strong>Account Status:</strong> <?php echo htmlspecialchars($customer->getAccountStatus()); ?>
                    </p>
                    <p><strong>Promotional Offers:</strong> <?php echo htmlspecialchars($customer->getPromoStatus()); ?>
                    </p>
                </div>
                <div class="address-info">
                    <h2>Address</h2>
                    <?php
                    $address = $customer->getAddressString();
                    if ($address) {
                        echo "<p>" . $address . ', ' . $city->getZipcode() . ' ' . $city->getCity() ."</p>";
                        echo "<p>Delivery available: " . ($city->getDeliveryAvailability() ? "Yes" : "No") . "</p>";
                    } else {
                        echo "<p>No address provided.</p>";
                    }
                    ?>
                </div>
                <!-- Link to edit profile or logout -->
                <a href="customer.php?action=edit">Edit Profile</a>
                <a href="logout.php">Log out</a>
            </div>
        </div>
    </main>