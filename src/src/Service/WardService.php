<?php

namespace App\Service;

use App\Dto\Ward\CreateWardDto;
use App\Entity\Ward;
use Doctrine\ORM\EntityManagerInterface;

class WardService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function createWard(CreateWardDto $dto): Ward
    {
        $ward = new Ward();
        $ward->setWardNumber($dto->ward_number);
        $ward->setDescription($dto->description);

        $this->entityManager->persist($ward);
        $this->entityManager->flush();

        return $ward;
    }
}