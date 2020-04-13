<?php

namespace App\DataTransformer;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use App\Utils\DependencyInjection\Validator;

abstract class ValidateInput extends InputTransformer
{
    use Validator;

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return parent::supportsTransformation($data, $to, $context) && $this->validate($data, $to, $context);
    }

    private function validate($data, string $to, array $context): bool
    {
        $inputClassName = $context['input']['class'] ?? false;
        if ($inputClassName) {
            $inputInstance = new $inputClassName;

            if ($inputInstance instanceof ValidationInput) {
                $violations = $this->validator->validate($data, $inputInstance->constraints());

                if ($violations->count() !== 0) {
                    throw new ValidationException($violations);
                }

                return true;
            }

            return true;
        }

        return true;
    }
}
