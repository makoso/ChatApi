<?php

namespace App\Actions\Room\Shared;

use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\UuidInterface;

/** @ApiResource() */
final class Output
{
    public UuidInterface $id;
    public string $name;
    public bool $private;
    public int $membersCount;
    public bool $alreadyJoined;
}
