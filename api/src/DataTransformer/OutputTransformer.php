<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

abstract class OutputTransformer implements DataTransformerInterface
{
    protected string $resourceClass;
    protected string $toClass;

    public function transform($object, string $to, array $context = [])
    {
        return $this->__invoke($object, $to, $context);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof $this->resourceClass
            && ($context['output']['class'] ?? '') === $this->toClass;
    }
}
