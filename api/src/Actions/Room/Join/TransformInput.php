<?php

namespace App\Actions\Room\Join;

use App\DataTransformer\InputTransformer;
use App\Entity\Room;
use App\Utils\DependencyInjection\UserContext;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;

class TransformInput extends InputTransformer
{
    use UserContext;
    private UserPasswordEncoderInterface $passwordEncoder;
    protected string $inputClass = Input::class;
    protected string $toClass = Room::class;

    public function __invoke(Input $object, string $to, array $context = []): Room
    {
        /** @var Room $room */
        $room = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];

        $room->addMember($this->getUser());

        return $room;
    }

}
