<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Dto\Patient\CreatePatientDto;

class IdentifiedBirthdayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IdentifiedBirthday) {
            throw new \InvalidArgumentException('Неверный тип ограничения');
        }

        if ($value instanceof CreatePatientDto && !$value->isIdentified && $value->birthday !== null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('birthday')
                ->addViolation();
        }
    }
}