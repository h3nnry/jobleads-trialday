<?php

namespace App\Test\Unit\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\DoctrineCustomerRegistrationService;
use App\Service\EmailServiceInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CustomerRegistrationServiceTest extends TestCase
{
    use ProphecyTrait;

    private DoctrineCustomerRegistrationService $customerRegistrationService;

    private CustomerRepository&MockObject $customerRepository;

    private EmailServiceInterface&MockObject $emailService;

    protected function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->emailService = $this->createMock(EmailServiceInterface::class);
        $this->customerRegistrationService = new DoctrineCustomerRegistrationService(
            $this->customerRepository,
            $this->emailService,
        );
    }

    #[DataProvider('registerDataProvider')]
    public function testRegister(Customer $customer): void
    {
        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with($customer);

        $this->emailService
            ->expects($this->once())
            ->method('sendCustomerRegistrationEmail')
            ->with($customer);
        $this->customerRegistrationService->register($customer);

    }

    public static function registerDataProvider(): array
    {
        return [
            'Valid customer with last name not null' => [
                'customer' => self::createCustomer('john.doe@example.com', 'Doe', 'Doe'),
            ],
            'Valid customer with last name null' => [
                'customer' => self::createCustomer('john.doe@example.com', 'Doe', null),
            ]
        ];
    }

    private static function createCustomer(string $email, string $firstname, ?string $lastName): Customer
    {
        $customer = new Customer();
        $customer->setEmail($email);
        $customer->setFirstName($firstname);

        if ($lastName !== null) {
            $customer->setLastName($lastName);
        }

        return $customer;
    }
}
