<?php

namespace App\Dto\Patient;

use App\Enum\GenderEnum;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePatientDto
{
    #[Assert\Length(
        min: 1,
        max: 80,
        minMessage: "Имя должно иметь минимум 1 символ",
        maxMessage: "Имя не должно быть длинее 80 символов."
    )]
    public string $name;

    #[Assert\Length(
        min: 1,
        max: 80,
        minMessage: "Фамилия должна иметь минимум 1 символ",
        maxMessage: "Фамилия не должна быть длинее 80 символов."
    )]
    public string $lastName;

    #[Assert\NotBlank]
    public GenderEnum $gender;

    #[Assert\NotNull]
    public bool $isIdentified;

    #[Assert\Type(type: "integer")]
    public ?int $cardNumber = null;
}
