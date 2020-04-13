<?php

namespace App\Actions\Message\Create;

use App\DataTransformer\ValidateInput;
use App\Entity\Message;
use App\Utils\DependencyInjection\UserContext;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TransformInput extends ValidateInput
{
    use UserContext;
    private UserPasswordEncoderInterface $passwordEncoder;
    protected string $inputClass = Input::class;
    protected string $toClass = Message::class;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(Input $object, string $to, array $context = []): Message
    {
        $message = new Message();

        $message->setMessage($object->message);
        $message->setAuthor($this->getUser());
        $message->setRoom($object->room);

        return $message;
    }

}
