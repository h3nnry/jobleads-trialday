<?php

namespace App\Test\Integration\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\CustomerRegistrationService;
use App\Service\DoctrineCustomerRegistrationService;
use App\Service\EmailServiceInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerRegistrationServiceTest extends WebTestCase
{
    use ProphecyTrait;

    public function testIntegration()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();

        $service = $container->get(CustomerRegistrationService::class);

        $this->assertInstanceOf(CustomerRegistrationService::class, $service);

        $customer = new Customer();
        $customer->setFirstName('John');
        $customer->setLastName('Doe');
        $customer->setEmail('john.doe@example.com');
        $service->register($customer);

        $this->assertEmailCount(1);
        $this->assertNotNull($customer->getId());
    }
}
