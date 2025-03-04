<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\CustomerRegistrationService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use OpenApi\Attributes as OA;

/**
 * This controller is using FOSRestBundle which is responsible for providing the right output for request.
 * The default setting is to return JSON response - so each returned by the controller action value is serialized to JSON
 * Response Format is based on _format attribute.
 */
#[Route('/api/v1/customer', requirements: ['version' => 'v\d+'])]
class CustomerController extends AbstractFOSRestController
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly CustomerRegistrationService $customerRegistrationService
    )
    {
    }

    #[OA\Response(
        response: 200,
        description: "Returns the list of customers",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(ref: new Model(type: Customer::class))
        )
    )]
    #[Rest\Get('.{_format}', name: 'customer_list', defaults: ['_format' => '~'])]
    #[Rest\View]
    public function list()
    {
        return $this->customerRepository->findAll();
    }

    #[OA\Response(
        response: 200,
        description: "Returns the customer by id",
        content: new OA\JsonContent(
            ref: new Model(type: Customer::class)
        )
    )]
    #[Rest\Get('/{id}.{_format}', name: 'customer_get', defaults: ['_format' => '~'])]
    #[Rest\View]
    public function getCustomer(Customer $customer)
    {
        return $customer;
    }

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: Customer::class,
            example: [
                "firstName" => "Max",
                "lastName" => "Musterman",
                "email" => "max.musterman@jobleads.com",
                "phoneNumber" => "+48 123 456 789"
            ]
        )
    )]
    #[Rest\Post('', name: 'customer_create')]
    #[Rest\View(statusCode: Response::HTTP_CREATED)]
    #[ParamConverter('customer', converter: 'fos_rest.request_body')]
    public function create(Customer $customer, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->customerRegistrationService->register($customer);

        return ['id' => $customer->getId()];
    }
}
