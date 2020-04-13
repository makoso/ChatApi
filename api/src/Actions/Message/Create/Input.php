<?php

namespace App\Actions\Message\Create;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DataTransformer\ValidationInput;
use App\Entity\Room;
use Symfony\Component\Validator\Constraints as Assert;

/** @ApiResource() */
final class Input implements ValidationInput
{
    public string $message;
    /** @var Room */
    public Room $room;

    public function constraints(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'message' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                ],
                'room' => [
                    new Assert\NotNull(),
                ],
            ]
        );
    }
}
