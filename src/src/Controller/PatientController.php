<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Patient\CreatePatientDto;
use App\Service\PatientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PatientController extends AbstractController
{
    #[Route('/patients', name: 'get_patients', methods: ['GET'])]
    public function getAllPatients(
        PatientService $patientService
    ): JsonResponse
    {
        return new JsonResponse($patientService->getPatients(), Response::HTTP_OK, [], true);
    }

    #[Route('/patients', name: 'create_patient', methods: ['POST'])]
    public function createPatient(
        #[MapRequestPayload] CreatePatientDto $dto,
        PatientService $patientService,
    ): JsonResponse
    {
        $patient = $patientService->createPatient($dto);

        return new JsonResponse(
            ['message' => 'Patient created successfully', 'patientName' => $patient->getName()],
            Response::HTTP_CREATED
        );
    }

    #[Route('/patients/{id}', name: 'delete_patient', methods: ['DELETE'])]
    public function deletePatient(
        int $id,
        PatientService $patientService
    ): JsonResponse
    {
        $patientService->deletePatient($id);

        return new JsonResponse(['message' => 'Patient deleted successfully'], Response::HTTP_OK);
    }
}
