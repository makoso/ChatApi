<?php

namespace App\Actions\Message\Shared;

use App\DataTransformer\OutputTransformer;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\Contract\ORM\Rooms;

class TransformUserOutput extends OutputTransformer
{
    protected string $resourceClass = User::class;
    protected string $toClass = MessageOutput::class;

    public function __invoke(User $object, string $to, array $context = []): UserOutput
    {
        $user = new UserOutput();

        $user->id = $object->getId();
        $user->firstName = $object->getFirstName();
        $user->lastName = $object->getLastName();
        $user->username = $object->getUsername();

        return $user;
    }

}
