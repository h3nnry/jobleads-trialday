<?php

namespace App\Test\Controller;

use App\Factory\CustomerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CustomerControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public const int CUSTOMER_ID = 1;
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/api/v1/customer';

    public function assertElementHasCustomerField(mixed $element): void
    {
        self::assertArrayHasKey('firstName', $element);
        self::assertArrayHasKey('lastName', $element);
        self::assertArrayHasKey('email', $element);
        self::assertArrayHasKey('phoneNumber', $element);
    }

    protected function setUp(): void
    {
        $this->client = static::createAuthenticatedClient();
        CustomerFactory::createMany(2);
    }

    private function createAuthenticatedClient($username = 'root_admin', $password = 'jobleads'): KernelBrowser
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password,
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    public function testIndex(): void
    {
        $this->client->request('GET', $this->path);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $element = $responseData[0];

        self::assertResponseStatusCodeSame(200);
        self::assertCount(2, $responseData);
        $this->assertElementHasCustomerField($element);
    }

    public function testNew(): void
    {
        $this->client->jsonRequest('POST', $this->path, [
            'firstName' => 'Max',
            'lastName' => 'Musterman',
            'email' => 'max.musterman@jobleads.com',
            'phoneNumber' => '+49123456789',
        ]);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertArrayHasKey('id', $responseData);
    }

    public function testShow(): void
    {
        $this->client->request('GET', sprintf('%s/%d', $this->path, self::CUSTOMER_ID));
        $element = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertElementHasCustomerField($element);
    }
}
