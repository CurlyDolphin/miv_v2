<?php

namespace App\Controller;

use App\Dto\Ward\CreateWardDto;
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
    )
    {
        $ward = $wardService->updateWard($id, $dto);

        return new JsonResponse(
            ['message' => 'Ward updated successfully', 'Ward Number' => $ward->getWardNumber()],
            Response::HTTP_OK
        );
    }
}