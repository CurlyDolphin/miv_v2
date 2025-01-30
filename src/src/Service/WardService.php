<?php

namespace App\Service;

use App\Dto\Ward\CreateWardDto;
use App\Entity\Ward;
use App\Repository\WardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class WardService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly WardRepository $wardRepository,
        private readonly SerializerInterface $serializer
    ) {}

    public function getWards()
    {
        $procedures = $this->wardRepository->findAll();

        return $this->serializer->serialize($procedures, 'json');
    }

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