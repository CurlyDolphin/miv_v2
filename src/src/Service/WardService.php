<?php

namespace App\Service;

use App\Dto\Ward\CreateWardDto;
use App\Dto\Ward\UpdateWardProcedureDto;
use App\Entity\Procedure;
use App\Entity\Ward;
use App\Entity\WardProcedure;
use App\Repository\WardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WardService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly WardRepository         $wardRepository,
        private readonly SerializerInterface    $serializer,
        private readonly ValidatorInterface     $validator,
    ) {}

    public function getWards()
    {
        $wards = $this->wardRepository->findAll();

        return $this->serializer->serialize($wards, 'json', ['groups' => 'ward:read']);
    }

    public function createWard(CreateWardDto $dto): Ward
    {
        $ward = new Ward();
        $ward->setWardNumber($dto->wardNumber);
        $ward->setDescription($dto->description);

        $this->entityManager->persist($ward);
        $this->entityManager->flush();

        return $ward;
    }

    public function updateWard(int $id, CreateWardDto $dto)
    {
        $ward = $this->wardRepository->find($id);

        if (!$ward) {
            throw new EntityNotFoundException('Ward not found');
        }

        $ward->setWardNumber($dto->wardNumber);
        $ward->setDescription($dto->description);

        $this->entityManager->persist($ward);
        $this->entityManager->flush();

        return $ward;
    }

    public function getWardInfo(int $wardId): array
    {
        $ward = $this->wardRepository->findWardWithPatients($wardId);

        if (!$ward) {
            throw new EntityNotFoundException('Ward not found');
        }

        $patients = [];
        foreach ($ward->getHospitalizations() as $hospitalization) {
            $patient = $hospitalization->getPatient();
            $patients[] = [
                'id'       => $patient->getId(),
                'name'     => $patient->getName(),
                'lastName' => $patient->getLastName(),
            ];
        }

        return [
            'wardNumber' => $ward->getWardNumber(),
            'patients'   => $patients,
        ];
    }

    public function updateWardProcedures(int $wardId, UpdateWardProcedureDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $violation) {
                $errorMessages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
            }
            throw new \InvalidArgumentException(implode('; ', $errorMessages));
        }

        $ward = $this->wardRepository->find($wardId);
        if (!$ward) {
            throw new EntityNotFoundException('Палата не найдена');
        }

        foreach ($dto->procedures as $procedureData) {
            $procedure = $this->entityManager
                ->getRepository(Procedure::class)
                ->find($procedureData['procedure_id']);
            if (!$procedure) {
                throw new EntityNotFoundException(
                    sprintf('Процедура с id %d не найдена', $procedureData['procedure_id'])
                );
            }

            $wardProcedure = new WardProcedure();
            $wardProcedure->setWard($ward);
            $wardProcedure->setProcedure($procedure);
            $wardProcedure->setSequence((int)$procedureData['sequence']);

            $this->entityManager->persist($wardProcedure);
        }

        $this->entityManager->flush();
    }
}