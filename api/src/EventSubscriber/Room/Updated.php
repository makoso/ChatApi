<?php

namespace App\EventSubscriber\Room;

use App\Entity\Message;
use App\Entity\Room;
use App\Event\Room\RoomUpdated;
use App\EventSubscriber\ResourceCreated;
use App\Utils\DependencyInjection\Bus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class Updated extends ResourceCreated
{
    use Bus;

    protected string $resourceClass = Room::class;
    protected array $methods = [Request::METHOD_PUT];

    /**
     * @param Message $object
     * @param ViewEvent $event
     */
    protected function onCreated($object, ViewEvent $event): void
    {
        $event = new RoomUpdated($object->getId());

        $this->bus->dispatch($event);
    }
}
