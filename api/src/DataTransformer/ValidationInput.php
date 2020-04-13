<?php

namespace App\DataTransformer;

use Symfony\Component\Validator\Constraints\Collection;

interface ValidationInput
{
    public function constraints(): Collection;
}
