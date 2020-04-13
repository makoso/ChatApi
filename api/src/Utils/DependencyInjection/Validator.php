<?php

namespace App\Utils\DependencyInjection;

use Symfony\Component\Validator\Validator\ValidatorInterface;

trait Validator
{
    protected ValidatorInterface $validator;

    /** @required */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }
}
