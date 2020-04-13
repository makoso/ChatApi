<?php

namespace App\Event\Room;

use Ramsey\Uuid\UuidInterface;

class RoomUpdated
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
