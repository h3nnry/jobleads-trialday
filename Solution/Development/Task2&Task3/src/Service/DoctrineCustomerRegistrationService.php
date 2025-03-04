<?php

namespace App\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Exception;

#[AsAlias(id: CustomerRegistrationService::class, public: true)]
readonly class DoctrineCustomerRegistrationService implements CustomerRegistrationService
{

    public function __construct(
        private CustomerRepository $customerRepository,
        private EmailServiceInterface $emailService,
    )
    {
    }

    public function register(Customer $customer): void
    {
        try {
            $this->customerRepository->save($customer);
            $this->emailService->sendCustomerRegistrationEmail($customer);
        } catch (Exception $exception) {
            // logs go here
        }

    }
}
