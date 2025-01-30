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
}