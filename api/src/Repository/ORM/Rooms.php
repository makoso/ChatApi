<?php

namespace App\Repository\ORM;

use App\Entity\Room;
use App\Entity\User;
use App\Repository\Contract\ORM\Rooms as RoomsContract;
use App\Utils\DependencyInjection\EntityManager;

class Rooms implements RoomsContract
{
    use EntityManager;

    public function userIsMemberOfRoom(Room $room, User $user): bool
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('1')
            ->from(Room::class, 'room')
            ->leftJoin('room.members', 'members')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('room.id', ':roomId'),
                    $qb->expr()->eq('members.id', ':userId')
                )
            )
            ->setParameters(
                [
                    'roomId' => $room->getId()->toString(),
                    'userId' => $user->getId()->toString(),
                ]
            );

        return count($qb->getQuery()->getArrayResult()) > 0;
    }
}
