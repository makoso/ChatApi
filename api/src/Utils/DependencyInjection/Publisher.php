<?php

namespace App\Utils\DependencyInjection;

use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

trait Publisher
{
    private PublisherInterface $publisher;

    /** @required */
    public function setPublisher(PublisherInterface $publisher): void
    {
        $this->publisher = $publisher;
    }

    protected function publish(Update $update): void
    {
        $publisher = $this->publisher;

        dump($publisher($update));
    }

}
