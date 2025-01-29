<?php

namespace App\Service;

use App\Dto\Procedure\CreateProcedureDto;
use App\Dto\Procedure\UpdateProcedureDto;
use App\Entity\Procedure;
use App\Repository\ProcedureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProcedureService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProcedureRepository $procedureRepository,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function getProcedures()
    {
        $procedures = $this->procedureRepository->findAll();

        return $this->serializer->serialize($procedures, 'json');
    }

    public function createProcedure(CreateProcedureDto $dto): Procedure
    {
        $procedure = new Procedure();
        $procedure->setName($dto->name);
        $procedure->setDescription($dto->description);

        $this->entityManager->persist($procedure);
        $this->entityManager->flush();

        return $procedure;
    }

    public function updateProcedure(int $id, UpdateProcedureDto $dto): Procedure
    {
        $procedure = $this->entityManager->getRepository(Procedure::class)->find($id);

        $procedure->setName($dto->name);
        $procedure->setDescription($dto->description);

        $this->entityManager->persist($procedure);
        $this->entityManager->flush();

        return $procedure;
    }
}
