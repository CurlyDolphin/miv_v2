<?php

namespace App\Dto\Procedure;

use Symfony\Component\Validator\Constraints as Assert;

class CreateProcedureDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string', message: "Имя должно быть строкой")]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Type('string', message: "Описание должно быть строкой")]
    public string $description;
}
