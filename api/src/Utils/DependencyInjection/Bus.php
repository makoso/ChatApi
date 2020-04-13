<?php

namespace App\Utils\DependencyInjection;

use Symfony\Component\Messenger\MessageBusInterface;

trait Bus
{
    protected MessageBusInterface $bus;

    /** @required */
    public function setBus(MessageBusInterface $bus): void
    {
        $this->bus = $bus;
    }

}
