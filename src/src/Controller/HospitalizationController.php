<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Hospitalization\AssignPatientDto;
use App\Dto\Patient\UpdatePatientDto;
use App\Service\HospitalizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class HospitalizationController extends AbstractController
{
    #[Route('/patients/assign', name: 'assign_patient_to_ward', methods: ['POST'])]
    public function assignPatientToWard(
        #[MapRequestPayload] AssignPatientDto $dto,
        HospitalizationService                $hospitalizationService
    ): JsonResponse
    {
        $hospitalizationService->assignPatientToWard($dto);

        return new JsonResponse(['message' => 'Patient assigned to ward successfully'], Response::HTTP_OK);
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
}
