<?php

namespace App\Event\Message;

use Ramsey\Uuid\UuidInterface;

class MessageCreated
{
    private UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

}
