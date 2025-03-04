<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Classification;
use App\Entity\ClassificationStudent;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * This controller is using FOSRestBundle which is responsible for providing the right output for request.
 * The default setting is to return JSON response - so each returned by the controller action value is serialized to JSON
 * Response Format is based on _format attribute.
 */
class StudentController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/students-data', name: 'get_students_data')]
    public function getStudentsData(): Response
    {

        $studentRepository = $this->entityManager->getRepository(Student::class);
        $allStudentsGradeAverage = $studentRepository->findAllStudentsGradeAverage();

        $classificationRepository = $this->entityManager->getRepository(Classification::class);
        $allClassesGradeAverage = $classificationRepository->findAllClassesGradeAverage();

        $classificationStudentRepository = $this->entityManager->getRepository(ClassificationStudent::class);
        $overallGradeAverage = $classificationStudentRepository->findOverAllGradeAverage();


        return new Response(
            json_encode([
                'list of all students with their personal average grade' => $allStudentsGradeAverage,
                'average grade of all students for each class' => $allClassesGradeAverage,
                'overall average grade' => $overallGradeAverage,
            ])
        );
    }
}
