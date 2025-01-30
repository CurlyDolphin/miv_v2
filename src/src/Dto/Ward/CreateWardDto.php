<?php

namespace App\Dto\Ward;

use Symfony\Component\Validator\Constraints as Assert;

class CreateWardDto
{
    #[Assert\NotBlank]
    #[Assert\Range(min: 1, max: 999)]
    public int $ward_number;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    public string $description;
}