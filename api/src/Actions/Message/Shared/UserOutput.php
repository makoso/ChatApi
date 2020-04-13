<?php

namespace App\Actions\Message\Shared;

use Ramsey\Uuid\UuidInterface;

final class UserOutput
{
    public UuidInterface $id;
    public string $username;
    public string $firstName;
    public string $lastName;
}
