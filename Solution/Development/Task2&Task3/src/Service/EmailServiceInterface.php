<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;

interface EmailServiceInterface
{
    public function sendCustomerRegistrationEmail(Customer $customer): void;

    public function sendExportedJobs(string $to, string $attachmentPath): void;
}
