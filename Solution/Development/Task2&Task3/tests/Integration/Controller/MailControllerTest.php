<?php

namespace App\Test\Controller;

use App\Factory\RegistrationEmailLogFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class MailControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;
    private string $path = '/mail';

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }
    public function testShow(): void
    {
        $registrationEmailLog = RegistrationEmailLogFactory::createOne();
        $this->client->request('GET', sprintf('%s/%d', $this->path, $registrationEmailLog->getId()));
        $element = $this->client->getResponse()->getContent();

        $this->assertSame($element, $registrationEmailLog->getEmailBody());
    }
}
