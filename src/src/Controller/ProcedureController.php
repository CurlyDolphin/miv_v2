<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Procedure\CreateProcedureDto;
use App\Dto\Procedure\UpdateProcedureDto;
use App\Service\ProcedureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ProcedureController extends AbstractController
{
    #[Route('/procedures', name: 'get_procedures', methods: ['GET'])]
    public function getProcedures(ProcedureService $procedureService): JsonResponse
    {
        return new JsonResponse($procedureService->getProcedures(), Response::HTTP_OK, [], true);
    }

    #[Route('/procedures', name: 'create_procedure', methods: ['POST'])]
    public function createProcedure(
        #[MapRequestPayload] CreateProcedureDto $dto,
        ProcedureService $procedureService,
    ): JsonResponse {
        $procedure = $procedureService->createProcedure($dto);

        return new JsonResponse(
            ['message' => 'Procedure created successfully', 'procedureName' => $procedure->getName()],
            Response::HTTP_CREATED
        );
    }

    #[Route('/procedures/{id}', name: 'update_procedure', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateProcedure(
        int $id,
        #[MapRequestPayload] UpdateProcedureDto $dto,
        ProcedureService $procedureService,
    ): JsonResponse {
        $procedure = $procedureService->updateProcedure($id, $dto);

        return new JsonResponse(
            ['message' => 'Procedure updated successfully', 'procedureName' => $procedure->getName()],
            Response::HTTP_OK
        );
    }
}
