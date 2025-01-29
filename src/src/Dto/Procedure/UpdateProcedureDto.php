<?php

namespace App\Dto\Procedure;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProcedureDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $description;
}