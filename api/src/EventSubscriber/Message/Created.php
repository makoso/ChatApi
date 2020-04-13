<?php

namespace App\EventSubscriber\Message;

use App\Entity\Message;
use App\Event\Message\MessageCreated;
use App\EventSubscriber\ResourceCreated;
use App\Utils\DependencyInjection\Bus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class Created extends ResourceCreated
{
    use Bus;

    protected string $resourceClass = Message::class;
    protected array $methods = [Request::METHOD_POST];

    /**
     * @param Message $object
     * @param ViewEvent $event
     */
    protected function onCreated($object, ViewEvent $event): void
    {
        $event = new MessageCreated($object->getId());

        $this->bus->dispatch($event);
    }
}
