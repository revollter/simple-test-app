<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class PenColor extends Constraint
{
    public string $message = 'Please enter a valid pen color.';
}