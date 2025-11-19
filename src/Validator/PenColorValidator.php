<?php

namespace App\Validator;

use App\Entity\Data;
use App\Enum\Product;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class PenColorValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof Data) {
            return;
        }

        if ($value->getProduct() === Product::PEN && $value->getColor() === null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('color')
                ->addViolation();
        }
    }
}
