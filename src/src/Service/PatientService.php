<?php

namespace App\Service;

use App\Dto\Patient\AssignPatientDto;
use App\Dto\Patient\CreatePatientDto;
use App\Entity\Hospitalized;
use App\Entity\Patient;
use App\Entity\Ward;
use App\Enum\GenderEnum;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
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

    public function getPatients(): string
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
            $dto->name = match ($dto->gender) {
                GenderEnum::MALE => 'John',
                GenderEnum::FEMALE => 'Jane',
                GenderEnum::OTHER => 'Alex',
            };
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

    public function deletePatient(int $id): void
    {
        $patient = $this->patientRepository->find($id);

        if (!$patient) {
            throw new EntityNotFoundException('Patient not found');
        }

        $this->entityManager->remove($patient);
        $this->entityManager->flush();
    }

    private function generateUniqueCardNumber(): int
    {
        for ($i = 0; $i < 10; $i++) { // 10 попыток
            $cardNumber = random_int(100000, 999999);
            if (!$this->patientRepository->findOneBy(['cardNumber' => $cardNumber])) {
                return $cardNumber;
            }
        }

        throw new \RuntimeException('Could not generate a unique card number');
    }

    public function assignPatientToWard(AssignPatientDto $dto): Hospitalized
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $patient = $this->patientRepository->find($dto->patientId);
        if (!$patient) {
            throw new EntityNotFoundException('Patient not found');
        }

        $ward = $this->entityManager->getRepository(Ward::class)->find($dto->wardId);
        if (!$ward) {
            throw new EntityNotFoundException('Ward not found');
        }

        $hospitalized = new Hospitalized();
        $hospitalized->setPatient($patient);
        $hospitalized->setWard($ward);

        $this->entityManager->persist($hospitalized);
        $this->entityManager->flush();

        return $hospitalized;
    }
}
