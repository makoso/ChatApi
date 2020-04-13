<?php

namespace App\Actions\Room\Create;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DataTransformer\ValidationInput;
use App\Entity\Room;
use Symfony\Component\Validator\Constraints as Assert;

/** @ApiResource() */
final class Input implements ValidationInput
{
    public string $name;
    public bool $private;

    public function constraints(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'name' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                ],
                'private' => [
                    new Assert\Type(['type' => 'boolean']),
                    new Assert\NotNull(),
                ],
            ]
        );
    }
}
