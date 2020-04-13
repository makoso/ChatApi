<?php

namespace App\Actions\Message\Shared;

use App\DataTransformer\OutputTransformer;
use App\Entity\Message;
use App\Repository\Contract\ORM\Rooms;

class TransformMessageOutput extends OutputTransformer
{
    private Rooms $rooms;
    private TransformUserOutput $transformUserOutput;
    protected string $resourceClass = Message::class;
    protected string $toClass = MessageOutput::class;

    public function __construct(Rooms $rooms, TransformUserOutput $transformUserOutput)
    {
        $this->rooms = $rooms;
        $this->transformUserOutput = $transformUserOutput;
    }

    public function __invoke(Message $object, string $to, array $context = []): MessageOutput
    {
        $transformUserOutput = $this->transformUserOutput;
        $message = new MessageOutput();

        $message->id = $object->getId();
        $message->author = $transformUserOutput($object->getAuthor(), $to, $context);
        $message->message = $object->getMessage();
        $message->sendAt = $object->getSendAt();

        return $message;
    }

}
