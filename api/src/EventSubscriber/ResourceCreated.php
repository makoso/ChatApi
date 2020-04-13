<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

abstract class ResourceCreated implements EventSubscriberInterface
{
    protected string $resourceClass = '';
    protected array $methods = [];

    abstract protected function onCreated($object, ViewEvent $event): void;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['handle', EventPriorities::POST_WRITE],
        ];
    }

    public function handle(ViewEvent $event): void
    {
        if (!$this->canProcessThisResource(
            $event->getControllerResult(),
            $event
        )) {
            return;
        }

        $this->onCreated($event->getControllerResult(), $event);
    }

    private function canProcessThisResource($object, KernelEvent $event): bool
    {
        return $this->isCorrectObject($object)
            && $this->isCorrectRequestMethod($event->getRequest());
    }

    private function isCorrectObject($object): bool
    {
        return $object instanceof $this->resourceClass;
    }

    private function isCorrectRequestMethod(Request $request): bool
    {
        return in_array($request->getMethod(), $this->methods, true);
    }
}
