<?php

namespace App\Service;

use App\Entity\Customer;
interface CustomerRegistrationService
{
    public function register(Customer $customer): void;
}
