<?php

namespace App\Utils\DependencyInjection;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait UserContext
{
    protected TokenStorageInterface $tokenStorage;

    /** @required */
    public function setTokenStorage(TokenStorageInterface $tokenStorage): void
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getUser(): User
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
