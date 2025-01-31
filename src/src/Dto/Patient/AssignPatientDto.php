<?php

namespace App\Dto\Patient;
use Symfony\Component\Validator\Constraints as Assert;

class AssignPatientDto
{
    #[Assert\NotBlank]
    public int $patientId;

    #[Assert\NotBlank]
    public int $wardId;
}