<?php

namespace App\Repository\Contract\ORM;

use App\Entity\Room;
use App\Entity\User;

interface Rooms
{
    public function userIsMemberOfRoom(Room $room, User $user): bool;
}
