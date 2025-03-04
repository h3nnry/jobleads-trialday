<?php

namespace App\Service;

use App\Command\JobExportCommand;
use App\Entity\Customer;
use App\Entity\RegistrationEmailLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


readonly class EmailService implements EmailServiceInterface
{
    private const FROM = "test@mail.com";
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
    ) {

    }
    public function sendCustomerRegistrationEmail(Customer $customer): void
    {
        $emailContent = 'Sending emails is fun again!';
        $email = (new Email())
            ->from(self::FROM)
            ->to($customer->getEmail())
            ->subject('Time for Symfony Mailer!')
            ->text($emailContent)
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        $emailLog = new RegistrationEmailLog();
        $emailLog->setEmailAddress($customer->getEmail());
        $emailLog->setEmailBody($emailContent);

        $this->entityManager->persist($emailLog);
        $this->entityManager->flush();


    }

    public function sendExportedJobs(string $to, string $attachmentPath): void
    {
        $email = (new Email())
            ->from(self::FROM)
            ->to($to)
            ->subject('Jobs exported!')
            ->text('See attached file for exported jobs.')
            ->attachFromPath($attachmentPath)
        ;

        $this->mailer->send($email);
    }

}
