<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Patient\CreatePatientDto;
use App\Dto\Patient\IdentifyPatientDto;
use App\Dto\Patient\UpdatePatientDto;
use App\Service\HospitalizationService;
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

    #[Route('/patients/{patientId}', name: 'get_patient', methods: ['GET'])]
    public function getPatientInfo(
        int            $patientId,
        PatientService $patientService
    ): JsonResponse
    {
        $patientInfo = $patientService->getPatientInfo($patientId);

        return new JsonResponse($patientInfo, Response::HTTP_OK, [], true);
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

    #[Route('/patients/{id}', name: 'update_patient', methods: ['PUT'])]
    public function updateWard(
        int $id,
        #[MapRequestPayload] UpdatePatientDto $dto,
        HospitalizationService                $hospitalizationService
    ): JsonResponse
    {
        $patient = $hospitalizationService->updatePatient($id, $dto);

        return new JsonResponse(
            ['message' => 'Patient updated successfully', 'Patient Name' => $patient->getName()],
            Response::HTTP_OK
        );
    }

    #[Route('/patients/identify/{id}', name: 'identify_patient', methods: ['PATCH'])]
    public function identifyPatient(
        int                                   $id,
        #[MapRequestPayload] IdentifyPatientDto $dto,
        PatientService $patientService
    ): JsonResponse
    {
        $patient = $patientService->identifyPatient($id, $dto);

        return new JsonResponse(
            ['message' => 'Patient identified successfully', 'patientName' => $patient->getName()],
            Response::HTTP_OK
        );
    }

    #[Route('/patients/{id}', name: 'delete_patient', methods: ['DELETE'])]
    public function deletePatient(
        int            $id,
        PatientService $patientService
    ): JsonResponse
    {
        $patientService->deletePatient($id);

        return new JsonResponse(['message' => 'Patient deleted successfully'], Response::HTTP_OK);
    }
}
