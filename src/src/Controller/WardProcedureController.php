<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\WardProcedure\UpdateWardProcedureDto;
use App\Service\WardProcedureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class WardProcedureController extends AbstractController
{
    #[Route('/wards/{wardId}/procedures', name: 'get_healing_plan', methods: ['GET'])]
    public function getWardProcedure(
        int                  $wardId,
        WardProcedureService $wardProcedureService
    ): JsonResponse
    {
        $jsonData = $wardProcedureService->getWardProcedures($wardId);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/wards/{wardId}/procedures', name: 'create_healing_plan', methods: ['POST'])]
    public function updateWardProcedure(
        int $wardId,
        #[MapRequestPayload] UpdateWardProcedureDto $dto,
        WardProcedureService                        $wardProcedureService
    ): JsonResponse
    {
        $wardProcedures = $wardProcedureService->updateWardProcedures($wardId, $dto);

        return new JsonResponse(
            ['message' => 'Ward procedures updated successfully', 'Procedures' => $wardProcedures],
            Response::HTTP_OK
        );
    }
}
