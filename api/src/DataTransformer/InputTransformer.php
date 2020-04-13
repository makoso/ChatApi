<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

abstract class InputTransformer implements DataTransformerInterface
{
    protected string $toClass;
    protected string $inputClass;

    public function transform($object, string $to, array $context = [])
    {
        return $this->__invoke($object, $to, $context);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return is_array($data)
            && $to === $this->toClass
            && ($context['input']['class'] ?? '') === $this->inputClass;
    }
}
