<?php

namespace App\Actions\User\Registration;

use App\DataTransformer\ValidateInput;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TransformInput extends ValidateInput
{
    private UserPasswordEncoderInterface $passwordEncoder;
    protected string $inputClass = Input::class;
    protected string $toClass = User::class;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(Input $object, string $to, array $context = []): User
    {
        $user = new User();

        $user->setUsername($object->username);
        $user->setFirstName($object->firstName);
        $user->setLastName($object->lastName);
        $user->setLastActivityAt(new \DateTimeImmutable());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $object->password));

        return $user;
    }

}
