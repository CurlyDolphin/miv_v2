<?php

namespace App\Controller;

use App\Dto\Ward\CreateWardDto;
use App\Dto\Ward\UpdateWardProcedureDto;
use App\Service\WardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class WardController extends AbstractController
{
    #[Route('/wards', name: 'get_wards', methods: ['GET'])]
    public function getWards(WardService $wardService): JsonResponse
    {
        return new JsonResponse($wardService->getWards(), Response::HTTP_OK, [], true);
    }

    #[Route('/wards', name: 'create_wards', methods: ['POST'])]
    public function createWards(
        #[MapRequestPayload] CreateWardDto $dto,
        WardService $wardService,
    ): JsonResponse
    {
        $ward = $wardService->createWard($dto);

        return new JsonResponse(
            ['message' => 'Ward created successfully', 'Ward Number' => $ward->getWardNumber()],
            Response::HTTP_CREATED
        );
    }

    #[Route('/wards/{id}', name: 'update_ward', methods: ['PUT'])]
    public function updateWard(
        int $id,
        #[MapRequestPayload] CreateWardDto $dto,
        WardService $wardService,
    ): JsonResponse
    {
        $ward = $wardService->updateWard($id, $dto);

        return new JsonResponse(
            ['message' => 'Ward updated successfully', 'Ward Number' => $ward->getWardNumber()],
            Response::HTTP_OK
        );
    }

    #[Route('/wards/{id}', name: 'get_ward_info', methods: ['GET'])]
    public function getWardInfo(
        int $id,
        WardService $wardService
    ): JsonResponse
    {
        $wardInfo = $wardService->getWardInfo($id);

        return new JsonResponse($wardInfo, Response::HTTP_OK);
    }

    #[Route('/wards/{wardId}/procedures', name: 'get_healing_plan', methods: ['GET'])]
    public function getWardProcedure(
        int $wardId,
        WardService $wardService
    ): JsonResponse
    {
        $jsonData = $wardService->getWardProcedures($wardId);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/wards/{wardId}/procedures', name: 'create_healing_plan', methods: ['POST'])]
    public function updateWardProcedure(
        int $wardId,
        #[MapRequestPayload] UpdateWardProcedureDto $dto,
        WardService $wardService
    ): JsonResponse
    {
        $wardProcedures = $wardService->updateWardProcedures($wardId, $dto);

        return new JsonResponse(
            ['message' => 'Ward procedures updated successfully', 'Procedures' => $wardProcedures],
            Response::HTTP_OK
        );
    }
}