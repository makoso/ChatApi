<?php

namespace App\Handler\Message;

use App\Actions\Message\Shared\MessageOutput;
use App\Entity\Message;
use App\Event\Message\MessageCreated;
use App\Utils\DependencyInjection\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class NotifyAfterMessageCreate implements MessageHandlerInterface
{
    use Publisher;

    private EntityManagerInterface $em;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->em = $entityManager;
    }

    public function __invoke(MessageCreated $messageCreated): void
    {
        $repo = $this->em->getRepository(Message::class);

        /** @var Message $message */
        $message = $repo->find($messageCreated->getId());

        $this->publish(
            new Update(
                '/r/'.$message->getRoom()->getId()->toString().'/m',
                $this->serializer->serialize($message, 'jsonld', ['output' => ['class' => MessageOutput::class]])
            )
        );
    }
}
