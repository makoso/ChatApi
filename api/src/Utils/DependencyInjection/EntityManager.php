<?php

namespace App\Utils\DependencyInjection;


use Doctrine\ORM\EntityManagerInterface;

trait EntityManager
{
    protected EntityManagerInterface $entityManager;

    /** @required */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

}
