<?php

namespace App\Actions\Room\Shared;

use App\DataTransformer\OutputTransformer;
use App\Entity\Room;
use App\Repository\Contract\ORM\Rooms;
use App\Utils\DependencyInjection\UserContext;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TransformOutput extends OutputTransformer
{
    use UserContext;
    private Rooms $rooms;
    protected string $resourceClass = Room::class;
    protected string $toClass = Output::class;

    public function __construct(Rooms $rooms)
    {
        $this->rooms = $rooms;
    }

    public function __invoke(Room $object, string $to, array $context = []): Output
    {
        $output = new Output();

        $output->id = $object->getId();
        $output->name = $object->getName();
        $output->private = $object->getPrivate();
        $output->membersCount = $object->getMembers()->count();
        $output->alreadyJoined = $this->rooms->userIsMemberOfRoom($object, $this->getUser());

        return $output;
    }

}
