<?php

namespace App\Dto\Patient;

use Symfony\Component\Validator\Constraints as Assert;
use App\Dto\Patient\Gender;


class CreatePatientDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $firstName;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $lastName;

    #[Assert\NotBlank]
    #[Assert\Date]
    public string $dateOfBirth;

    #[Assert\NotBlank]
    #[Assert\Type(Gender::class)]
    public Gender $gender;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $address;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $phoneNumber;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}