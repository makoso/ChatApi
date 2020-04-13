<?php

namespace App\Actions\Room\Create;

use App\DataTransformer\ValidateInput;
use App\Entity\Room;
use App\Utils\DependencyInjection\UserContext;

class TransformInput extends ValidateInput
{
    use UserContext;
    protected string $inputClass = Input::class;
    protected string $toClass = Room::class;

    public function __invoke(Input $object, string $to, array $context = []): Room
    {
        $room = new Room();

        $room->setName($object->name);
        $room->setCreator($this->getUser());
        $room->setOwner($this->getUser());
        $room->setPrivate($object->private === true);
        $room->setDirectMessageRoom(false);
        $room->addMember($this->getUser());

        return $room;
    }

}
