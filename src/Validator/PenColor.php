<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class PenColor extends Constraint
{
    public string $message = 'Please enter a valid pen color.';
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}