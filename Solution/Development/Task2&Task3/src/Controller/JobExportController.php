<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\JobExportFormat;
use App\Exception\JobExportFailure;
use App\Form\JobExportToEmailType;
use App\Service\EmailServiceInterface;
use App\Service\JobExportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class JobExportController extends AbstractController
{
    public function __construct(
        private readonly JobExportServiceInterface $jobExportService,
        private readonly EmailServiceInterface $emailService,
    ) {
    }

    #[Route('/job-export', name: 'get_job_export')]
    public function getRegistrationEmailLog(Request $request): Response
    {
        $form = $this->createForm(JobExportToEmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $exportFile = $this->jobExportService->export(JobExportFormat::tryFrom($formData['format']));
                $this->emailService->sendExportedJobs($formData['email'], $exportFile);
                $this->addFlash('success', 'Jobs exported and sent successfully!');

            } catch (JobExportFailure $e) {
                $this->addFlash('error', sprintf('Jobs export failed! %s', $e->getMessage()));
            }

        }

        return $this->render('job-export/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
