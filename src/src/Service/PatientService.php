<?php

namespace App\Service;


use App\Dto\Patient\CreatePatientDto;
use App\Entity\Patient;
use App\Enum\GenderEnum;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatientService
{
    public function __construct(
        private readonly PatientRepository      $patientRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface     $validator,
        private readonly SerializerInterface    $serializer
    ) {}

    public function getPatients()
    {
        $patients = $this->patientRepository->findAll();

        return $this->serializer->serialize($patients, 'json');
    }

    public function createPatient(CreatePatientDto $dto): Patient
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        if (!$dto->isIdentified) {
            $dto->name = $dto->gender === GenderEnum::MALE ? 'John' : ($dto->gender === GenderEnum::FEMALE ? 'Jane' : 'Alex');
            $dto->lastName = 'Doe';
        }

        $cardNumber = $dto->cardNumber ?? $this->generateUniqueCardNumber();

        $patient = new Patient();
        $patient->setName($dto->name);
        $patient->setLastName($dto->lastName);
        $patient->setGender($dto->gender);
        $patient->setIdentified($dto->isIdentified);
        $patient->setCardNumber($cardNumber);

        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $patient;
    }

    private function generateUniqueCardNumber(): int
    {
        do {
            $cardNumber = random_int(100000, 999999);
        } while ($this->patientRepository->findOneBy(['cardNumber' => $cardNumber]));

        return $cardNumber;
    }
}
