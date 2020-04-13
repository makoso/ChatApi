<?php

namespace App\Actions\User\Registration;

use App\DataTransformer\ValidationInput;
use Symfony\Component\Validator\Constraints as Assert;

final class Input implements ValidationInput
{
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $password;

    public function constraints(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'username' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 255]),
                ],
                'firstName' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ],
                'lastName' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ],
                'password' => [
                    new Assert\Type(['type' => 'string']),
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5]),
                ],
            ]
        );
    }
}
