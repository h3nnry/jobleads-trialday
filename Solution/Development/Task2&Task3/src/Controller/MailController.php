<?php

namespace App\Controller;

use App\Entity\RegistrationEmailLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MailController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/mail/{id}', name: 'get_registration_email_log')]
    public function getRegistrationEmailLog(RegistrationEmailLog $registrationEmailLog): Response
    {
        return new Response(
            $registrationEmailLog->getEmailBody()
        );
    }
}
