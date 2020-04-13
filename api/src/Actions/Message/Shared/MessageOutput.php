<?php

namespace App\Actions\Message\Shared;

use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\UuidInterface;

/** @ApiResource() */
final class MessageOutput
{
    public UuidInterface $id;
    public string $message;
    public UserOutput $author;
    public \DateTimeInterface $sendAt;
}
