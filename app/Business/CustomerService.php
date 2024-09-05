<?php
declare(strict_types=1);

namespace Business;

use Data\CustomerDAO;
use Entities\Customer;

class CustomerService
{
    private CustomerDAO $customerDAO;

    public function __construct()
    {
        $this->customerDAO = new CustomerDAO();
    }

    /**
     * Retrieves all customers.
     *
     * @return array Returns an array of Customer objects.
     */
    public function getCustomers(): array
    {
        try {
            return $this->customerDAO->getAll();
        } catch (\Exception $e) {
            error_log("Error fetching customers: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Creates a new customer.
     *
     * @param Customer $customer The customer to create.
     * @return bool Returns true on success, false on failure.
     */
    public function newCustomer(Customer $customer): ?Customer
    {
        try {
            return $this->customerDAO->create($customer);
        } catch (\Exception $e) {
            error_log("Error creating customer: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieves a customer by email.
     *
     * @return Customer|null Returns the Customer object if found, null otherwise.
     */
    public function getByEmail(string $email): ?Customer
    {
        try {
            return $this->customerDAO->getByEmail($email);
        } catch (\Exception $e) {
            error_log("Error fetching customer by email: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Updates a customer by id.
     *
     * @param Customer $customer The class of the customer to update.
     * @return true Returns true if the customer was updated, false otherwise.
     */
    public function updateCustomer(): ?Customer
    {
        try {
            $customer = new Customer();
            $customer->setId(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
            $customer->setSurname(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $customer->setPhone(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setAccountStatus(filter_input(INPUT_POST, 'account_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setPassword(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setPromoStatus(filter_input(INPUT_POST, 'promo_status', FILTER_SANITIZE_NUMBER_INT));
            $customer->setStreet(filter_input(INPUT_POST, 'street', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $customer->setNumber(filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT));
            $customer->setCityId(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_NUMBER_INT));

            $customerArray = $customer->toArray();
            return $this->customerDAO->update($customerArray, $customer->getId());

        } catch (\Exception $e) {
            error_log("Error updating customer: " . $e->getMessage());
            return null; // Return null in case of failure
        }
    }
}
