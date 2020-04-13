<?php

namespace App\Handler\Room;

use App\Actions\Room\Shared\Output;
use App\Entity\Room;
use App\Event\Room\RoomUpdated;
use App\Utils\DependencyInjection\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Serializer\SerializerInterface;

class NotifyAfterRoomUpdated implements MessageHandlerInterface
{
    use Publisher;

    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        TokenStorageInterface $tokenStorage
    ) {
        $this->serializer = $serializer;
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(RoomUpdated $roomUpdated): void
    {
        $repo = $this->em->getRepository(Room::class);

        /** @var Room $room */
        $room = $repo->find($roomUpdated->getId());

        foreach ($room->getMembers() as $member) {
            $token = new UsernamePasswordToken(
                $member, null, 'main', $member->getRoles()
            );

            $this->tokenStorage->setToken($token);
            $this->publish(
                new Update(
                    '/r/'.$room->getId()->toString().'/r',
                    $this->serializer->serialize($room, 'jsonld', ['output' => ['class' => Output::class]])
                )
            );
        }
    }
}
